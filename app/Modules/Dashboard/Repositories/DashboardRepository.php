<?php
/**
 * Created by PhpStorm.
 * User: binita
 * Date: 9/9/16
 * Time: 11:43 AM
 */

namespace Modules\Dashboard\Repositories;


use Illuminate\Support\Facades\DB;
use Modules\Dashboard\Entities\ActiveRouteToday;
use Modules\Dashboard\Entities\ActiveRouteTodayAgg;
use Modules\Dashboard\Entities\DashboardInterface;
use Modules\Dashboard\Entities\RouteProductivityAgg;
use Modules\Dashboard\Entities\RouteProductivityToday;
use Modules\Dashboard\Entities\SalesProductivityAgg;
use Modules\Dashboard\Entities\SalesProductivityToday;
use Modules\Foundation\Repositories\AbstractRepository;
use Modules\Sales\Entities\RetailOutletInterface;
use Modules\Sales\Entities\Route;
use Modules\Sales\Repositories\NoOrderRepositoryInterface;
use Modules\Sales\Repositories\RouteRepository;
use Modules\Sales\Repositories\SalesOrderRepositoryInterface;
use Modules\Traits\Filterable;

class DashboardRepository extends AbstractRepository implements DashboardRepositoryInterface
{
    use Filterable;
    /**
     * The Model instance.
     *
     * @var DashboardInterface
     */
    protected $model;
    protected $activeRouteToday;
    protected $routeProductivityToday;
    protected $salesProductivityToday;
    protected $routeRepository;
    protected $routeModel;
    protected $activeRouteTodayAgg;
    protected $salesProductivityAgg;
    protected $routeProductivityAgg;
    protected $noOrderRepository;
    protected $retailOutletRepository;

    /**
     * Create a new AdjustmentRepository instance.
     *
     * @param ActiveRouteToday $activeRouteToday
     * @param RouteProductivityToday $routeProductivityToday
     * @param SalesProductivityToday $salesProductivityToday
     * @param SalesOrderRepositoryInterface $salesInterface
     * @param NoOrderRepositoryInterface $noOrderRepositoryInterface
     * @param RetailOutletInterface $retailOutletRepository
     * @param RouteRepository $routeRepository
     * @param Route $routeModel
     * @param SalesProductivityAgg $salesProductivityAgg
     * @param RouteProductivityAgg $routeProductivityAgg
     * @param ActiveRouteTodayAgg $activeRouteTodayAgg
     * @internal param DashboardInterface $model
     */
    public function __construct(
        ActiveRouteToday $activeRouteToday,
        RouteProductivityToday $routeProductivityToday,
        SalesProductivityToday $salesProductivityToday,
        SalesOrderRepositoryInterface $salesInterface,
        NoOrderRepositoryInterface $noOrderRepositoryInterface,
        RetailOutletInterface $retailOutletRepository,
        RouteRepository $routeRepository,
        Route $routeModel,
        SalesProductivityAgg $salesProductivityAgg,
        RouteProductivityAgg $routeProductivityAgg,
        ActiveRouteTodayAgg $activeRouteTodayAgg

    ) {
        $this->activeRouteToday = $activeRouteToday;
        $this->routeProductivityToday = $routeProductivityToday;
        $this->salesProductivityToday = $salesProductivityToday;
        $this->salesProductivityAgg = $salesProductivityAgg;
        $this->routeProductivityAgg = $routeProductivityAgg;
        $this->activeRouteTodayAgg = $activeRouteTodayAgg;
        $this->noOrderRepository = $noOrderRepositoryInterface;
        $this->retailOutletRepository;
        $this->routeRepository = $routeRepository;
        $this->routeModel = $routeModel;
    }


    public function getNationalReport()
    {
        $today_data = $this->routeProductivityToday
            ->select(DB::raw('count(distinct(user_id)) as dse'),
                DB::raw('count(distinct(retail_outlet_id)) as call_made'),
                DB::raw('COUNT(IF(unsucessful_call=1,1,NULL))  as unsucessful_call'),
                DB::raw('COUNT(IF(sucessful_call=1,1,NULL)) as sucessful_call'))->filtered()
            ->where('phone_order', '=', '0')->get()->toArray();


        return $today_data;
    }


    public function getNationalReportRoute()
    {

        $monthly_route_data = $this->activeRouteToday
            ->select(DB::raw('sum(schedule_call) as route_schedule'),
                DB::raw('sum(call_made) as route_call_made'),
                DB::raw('count(distinct(dse_route)) as dse_route'),
                DB::raw('count(distinct(route_id)) as active_route'),
                DB::raw('sum(call_not_performed) as call_not_performed'),
                DB::raw('sum(successfull_call) as route_sucessful_call'))->filtered()->where('phone_order', '=',
                '0')->get()->toArray();

        return $monthly_route_data;
    }


    public function getOfflineCall()
    {
        $offline_data = $this->routeProductivityToday
            ->select(DB::raw('count(distinct(retail_outlet_id)) as off_call'))
            ->filtered()->where('phone_order', '=', '1')->get()->toArray();
        return $offline_data;

    }


    public function getDetailOfflineRouteRetailOutlet($data)
    {


        $limit = null;

        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->routeProductivityToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_route_productivity_today.user_id')
            ->leftJoin('route', 'rpt_route_productivity_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_route_productivity_today.town_id', '=', 'town.id_town')
            ->leftJoin('retail_outlet', 'rpt_route_productivity_today.retail_outlet_id', '=',
                'retail_outlet.id_retail_outlet')
            ->distinct()
            ->select('route.title as route_title', 'retail_outlet.title as retail_outlet_title',
                'retail_outlet.id_retail_outlet as retail_outlet_id',
                'town.title as town_title', DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))
            ->orderby('id_route', 'asc')
            ->filtered()->where('rpt_route_productivity_today.phone_order', '=', '1');

        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }


        return $callInfo;
    }


    public function getTopFiveDSE()
    {
        $dse = $this->activeRouteToday->leftJoin('user', 'user.id_user', '=', 'rpt_active_route_today.dse_route')
            ->select(DB::raw('successfull_call/call_made as productivity'),
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as title"), 'route_id', 'dse_route')
            ->groupby('rpt_active_route_today.dse_route')->orderby('productivity', 'desc')->filtered()
            ->take(5)
            ->get()->toArray();
        //dd($dse);
        return $dse;
    }

    public function getTopFiveDSEByVolume()
    {
        $dseVol = $this->salesProductivityToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_sales_productivity_today.user_id')
            ->select(DB::raw('sum(qty) as qty'),
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as title"))->groupby('user_id')->orderby('qty',
                'desc')
            ->filtered()->take(5)->get();
        return $dseVol;
    }

    public function getOrderReceivedValue()
    {
        $orderReceived = $this->salesProductivityToday
            ->select(DB::raw('sum(order_received) as order_received'))
            ->filtered()->get()->all();
        return $orderReceived[0]['attributes'];
    }

//    public function getOrderDispatchedValue(){
//        $orderDispatched=  DB::table('rpt_sales_productivity_today')
//            ->select(DB::raw('sum(order_dispatched) as order_dispatched'))
//            ->get();
//        return $orderDispatched;
//    }

    public function getOrderInvoiceValue()
    {
        $orderInvoice = $this->salesProductivityToday
            ->select(DB::raw('sum(order_invoiced) as order_invoiced'))
            ->filtered()->get()->all();
        return $orderInvoice[0]['attributes'];
    }

    /***
     * Get the detail report of Active details
     * @return mixed
     */
    public function getDetailOfActiveDse($data)
    {

        $limit = null;

        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->activeRouteToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_active_route_today.dse_route')
            ->leftJoin('route', 'rpt_active_route_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'town.id_town', '=', 'route.town_id')
            ->leftJoin('distributor', 'rpt_active_route_today.distributor_id', '=', 'distributor.id_distributor')
            ->distinct()
            ->select('user.id_user', 'route.id_route', 'route.title as route_title', 'town.title as town_title',
                'distributor.title AS distributor_title',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))->orderby('id_user', 'asc')
            ->filtered()->where('rpt_active_route_today.phone_order', '=', '0');

        if ($limit) {
            $activeDseInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $activeDseInfo = $sql->get()->toArray();
        }
        return $activeDseInfo;
    }


    /***
     * GEt the detail of Scheduled Call
     * @return mixed
     */

    public function getDetailOfScheduledCall($data)
    {
        $limit = null;

        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->activeRouteToday
            ->leftJoin('route', 'rpt_active_route_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_active_route_today.town_id', '=', 'town.id_town')
            ->leftJoin('user', 'user.id_user', '=', 'rpt_active_route_today.dse_route')
            ->leftJoin('distributor', 'rpt_active_route_today.distributor_id', '=', 'distributor.id_distributor')
            ->distinct()
            ->select('route.title as route_title', 'town.title as town_title', 'distributor.title AS distributor_title',
                'route.id_route',
                'rpt_active_route_today.schedule_call as total_outlets', 'id_route',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))
            //    DB::raw('COUNT(IF(sucessful_call=1,1,NULL)) as sucessful_call'))
            ->orderby('id_route', 'asc')
            ->filtered()->where('rpt_active_route_today.phone_order', '=', '0');
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }

        return $callInfo;
    }

    /***
     * Get The schedule Call of that particular route
     * @param $data
     * @return mixed
     */
    public function getScheduleRouteRetailOutlet($data)
    {

        if (isset($data['route_id'])) {
            $route = $data['route_id'];
        }

        if (isset($data['user_id'])) {
            $user = $data['user_id'];
        }
        $sql = $this->activeRouteToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_active_route_today.dse_route')
            ->leftJoin('route', 'rpt_active_route_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_active_route_today.town_id', '=', 'town.id_town')
            ->leftJoin('distributor', 'rpt_active_route_today.distributor_id', '=', 'distributor.id_distributor')
            ->leftJoin('route_retail_outlet', 'route_retail_outlet.route_id', '=', 'route.id_route')
            ->leftJoin('retail_outlet', 'route_retail_outlet.retail_outlet_id', '=', 'retail_outlet.id_retail_outlet')
            ->leftJoin('rpt_route_productivity_today', 'rpt_route_productivity_today.retail_outlet_id', '=',
                'retail_outlet.id_retail_outlet')
            ->distinct()
            ->select('route.title as route_title', 'retail_outlet.title as retail_outlet_title', 'sucessful_call',
                'rpt_route_productivity_today.created_at', 'no_order_reason',
                'distributor.title AS distributor_title', 'route.id_route', 'unsucessful_call',
                'town.title as town_title', 'retail_outlet.id_retail_outlet as retail_outlet_id',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))
            //->orderby('rpt_route_productivity_today.created_at', 'asc')
            ->orderBy(DB::raw('ISNULL(rpt_route_productivity_today.created_at), rpt_route_productivity_today.created_at'),
                'desc')
            //  ->orderBy(DB::raw("coalesce(rpt_route_productivity_today.created_at, '')"), 'asc')
            ->orderby('sucessful_call', 'desc')
            ->orderby('unsucessful_call', 'desc')
            ->filtered()->where('rpt_active_route_today.phone_order', '=', '0');
        if (isset($route)) {
            $sql->where('rpt_active_route_today.route_id', '=', $route);
        }
        if (isset($user)) {
            $sql->where('rpt_active_route_today.dse_route', '=', $user);
        }

        // Only for the download section....

        $callInfo = $sql->get()->toArray();
        // dd($callInfo);

        return $callInfo;
    }


    /**
     * Get the detail of successful calls
     * @return mixed
     */

    public function getDetailOfSuccessFullCall($data = null)
    {
        $limit = null;

        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->routeProductivityToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_route_productivity_today.user_id')
            ->leftJoin('route', 'rpt_route_productivity_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_route_productivity_today.town_id', '=', 'town.id_town')
            ->leftJoin('distributor', 'rpt_route_productivity_today.distributor_id', '=', 'distributor.id_distributor')
            ->distinct()
            ->select('route.title as route_title', 'town.title as town_title', 'sucessful_call',
                'distributor.title AS distributor_title', 'route.id_route',
                'rpt_route_productivity_today.created_at',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"),
                DB::raw('COUNT(IF(sucessful_call=1,1,NULL)) as total_outlets'))
            ->where('rpt_route_productivity_today.sucessful_call', '=', '1')
            ->groupby('id_route')
            ->orderby('rpt_route_productivity_today.created_at', 'asc')
            ->filtered()->where('phone_order', '=', '0');
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }
        return $callInfo;
    }

    /**
     * Get the detail of successful calls
     * @return mixed
     */

    public function getSuccessfulRouteRetailOutlet($data)
    {
        $limit = null;
        if (isset($data['route_id'])) {
            $route = $data['route_id'];
        }
        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->routeProductivityToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_route_productivity_today.user_id')
            ->leftJoin('route', 'rpt_route_productivity_today.route_id', '=', 'route.id_route')
            ->leftJoin('retail_outlet', 'rpt_route_productivity_today.retail_outlet_id', '=',
                'retail_outlet.id_retail_outlet')
            ->leftJoin('distributor', 'rpt_route_productivity_today.distributor_id', '=', 'distributor.id_distributor')
            ->distinct()
            ->select('rpt_route_productivity_today.retail_outlet_id', 'route.title as route_title',
                'retail_outlet.title as retail_outlet_title', 'sucessful_call',
                'distributor.title AS distributor_title', 'route.id_route',
                'rpt_route_productivity_today.created_at',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))
            ->where('rpt_route_productivity_today.sucessful_call', '=', '1')
            ->orderby('rpt_route_productivity_today.created_at', 'asc')
            ->filtered()->where('phone_order', '=', '0');
        if (isset($route)) {
            $sql->where('rpt_route_productivity_today.route_id', '=', $route);
        }
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }
        return $callInfo;
    }

    /***
     * Get the detail of Unsuccessful Calls
     * @return mixed
     */
    public function getDetailOfUnSuccessFullCall($data = null)
    {

        $limit = null;

        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->routeProductivityToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_route_productivity_today.user_id')
            ->leftJoin('route', 'rpt_route_productivity_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_route_productivity_today.town_id', '=', 'town.id_town')
            ->leftJoin('distributor', 'rpt_route_productivity_today.distributor_id', '=', 'distributor.id_distributor')
            ->distinct()
            ->select('route.title as route_title', 'town.title as town_title', 'unsucessful_call',
                'distributor.title AS distributor_title', 'route.id_route',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"),
                DB::raw('COUNT(IF(unsucessful_call=1,1,NULL)) as total_outlets'))
            ->where('rpt_route_productivity_today.unsucessful_call', '=', '1')
            ->groupby('id_route')
            ->orderby('id_route', 'asc')
            ->filtered()->where('phone_order', '=', '0');
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }


        return $callInfo;
    }


    public function getUnSuccessfulRouteRetailOutlet($data)
    {
        $limit = null;
        if (isset($data['route_id'])) {
            $route = $data['route_id'];
        }
        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->routeProductivityToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_route_productivity_today.user_id')
            ->leftJoin('route', 'rpt_route_productivity_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_route_productivity_today.town_id', '=', 'town.id_town')
            ->leftJoin('distributor', 'rpt_route_productivity_today.distributor_id', '=', 'distributor.id_distributor')
            ->leftJoin('retail_outlet', 'rpt_route_productivity_today.retail_outlet_id', '=',
                'retail_outlet.id_retail_outlet')
            ->distinct()
            ->select('rpt_route_productivity_today.retail_outlet_id', 'route.title as route_title',
                'town.title as town_title', 'distributor.title AS distributor_title', 'route.id_route',
                'no_order_reason',
                'retail_outlet.title as retail_outlet_title', 'unsucessful_call',
                'rpt_route_productivity_today.created_at',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))
            ->where('rpt_route_productivity_today.unsucessful_call', '=', '1')
            ->orderby('rpt_route_productivity_today.created_at', 'asc')
            ->filtered()->where('phone_order', '=', '0');
        if (isset($route)) {
            $sql->where('rpt_route_productivity_today.route_id', '=', $route);
        }
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }
        return $callInfo;
    }

    /***
     * Get the details of all call Made
     * @return array
     */

    public function getDetailOfCallMade($data = null)
    {
        $limit = null;
        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->routeProductivityToday
            ->leftJoin('route', 'rpt_route_productivity_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_route_productivity_today.town_id', '=', 'town.id_town')
            ->leftJoin('user', 'user.id_user', '=', 'rpt_route_productivity_today.user_id')
            ->leftJoin('distributor', 'rpt_route_productivity_today.distributor_id', '=', 'distributor.id_distributor')
            ->distinct()
            ->select('route.title as route_title', 'town.title as town_title', 'distributor.title AS distributor_title',
                'route.id_route',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"),
                DB::raw('COUNT(IF(unsucessful_call=1,1,NULL)) as unsucessful_call'),
                DB::raw('COUNT(IF(sucessful_call=1,1,NULL)) as sucessful_call')
            )
            ->groupby('id_route')
            ->orderby('id_route', 'asc')
            ->filtered()->where('phone_order', '=', '0');
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }
        return $callInfo;

    }


    public function getDetailOfCallMadeRouteRetailOutlet($data)
    {
        $route = null;
        if (isset($data['route_id'])) {
            $route = $data['route_id'];
        }
        $limit = null;
        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $sql = $this->routeProductivityToday
            ->leftJoin('route', 'rpt_route_productivity_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_route_productivity_today.town_id', '=', 'town.id_town')
            ->leftJoin('user', 'user.id_user', '=', 'rpt_route_productivity_today.user_id')
            ->leftJoin('distributor', 'rpt_route_productivity_today.distributor_id', '=', 'distributor.id_distributor')
            ->leftJoin('retail_outlet', 'rpt_route_productivity_today.retail_outlet_id', '=',
                'retail_outlet.id_retail_outlet')
            ->distinct()
            ->select('rpt_route_productivity_today.retail_outlet_id', 'route.title as route_title',
                'town.title as town_title', 'route.id_route', 'unsucessful_call',
                'distributor.title AS distributor_title', 'route.id_route', 'no_order_reason',
                'sucessful_call', 'retail_outlet.title as retail_outlet_title',
                'rpt_route_productivity_today.created_at',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title")
            )
            ->orderby('rpt_route_productivity_today.created_at', 'asc')
            //->orderby('sucessful_call', 'desc')
            // ->orderby('unsucessful_call', 'desc')
            ->filtered()->where('phone_order', '=', '0');
        if (isset($route)) {
            $sql->where('route.id_route', '=', $route);
        }
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }
        return $callInfo;

    }

    public function getCallNotPerformedDetail($data)
    {
        $limit = null;

        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        $callInfo = null;
        $sql = $this->activeRouteToday->distinct()
            ->select('route.title as route_title', 'town.title as town_title', 'call_not_performed as total_outlets',
                'route.id_route', 'distributor.title AS distributor_title',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))
            ->leftJoin('route', 'rpt_active_route_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'route.town_id', '=', 'town.id_town')
            ->leftJoin('user', 'user.id_user', '=', 'rpt_active_route_today.dse_route')
            ->leftJoin('distributor', 'rpt_active_route_today.distributor_id', '=', 'distributor.id_distributor')
            ->filtered();
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }
        return $callInfo;
    }

    public function getCallNotPerformedRouteRetailOutlet($data)
    {

        $limit = null;

        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        if (isset($data['route_id'])) {
            $route = $data['route_id'];
        }
        $callInfo = null;
        $sql = $this->routeModel->distinct()
            ->select('retail_outlet.title as retail_outlet_title', 'route.title as route_title',
                'retail_outlet.id_retail_outlet as retail_outlet_id',
                'town.title as town_title', 'distributor.title AS distributor_title',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))
            ->leftJoin('town', 'route.town_id', '=', 'town.id_town')
            ->leftJoin('route_retail_outlet', 'route_retail_outlet.route_id', '=', 'route.id_route')
            ->leftJoin('retail_outlet', 'route_retail_outlet.retail_outlet_id', '=', 'retail_outlet.id_retail_outlet')
            ->leftJoin('user_route', 'user_route.route_id', '=', 'route.id_route')
            ->leftJoin('user', 'user.id_user', '=', 'user_route.user_id')
            ->leftJoin('sales_representative_distributor', 'user_route.user_id', '=',
                'sales_representative_distributor.user_id')
            ->leftJoin('distributor', 'distributor.id_distributor', '=',
                'sales_representative_distributor.distributor_id')
            ->whereIn('route_retail_outlet.route_id', function ($query) {
                $query->select(DB::raw('route_id'))->distinct()
                    ->from('rpt_active_route_today');
            })
            ->whereNotIn('route_retail_outlet.retail_outlet_id', function ($query) {
                $query->from('rpt_route_productivity_today')->distinct()
                    ->select('retail_outlet_id');
            })
            ->orderby('id_route', 'asc')
            ->orderby('retail_outlet.id_retail_outlet', 'asc')
            ->filtered();
        if (isset($route)) {
            $sql->where('route.id_route', '=', $route);
        }
        if ($limit) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }

        return $callInfo;
    }


    public function dseProductivityCumulativeReport($data)
    {
        $limit = null;
        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        if (isset($data['productivity'])) {
            $productivity = $data['productivity'];
        }
        if (!empty($data['start_date'])) {
            $start_date = $data['start_date'] . ' 00:00:00';;
        }
        if (!empty($data['end_date'])) {
            $end_date = $data['end_date'] . ' 23:59:59';
        }
        if (isset($data['group_flag']) && (($data['group_flag'] == 'true'))) {
            $groupFlag = $data['group_flag'];
        }
        $sql = $this->activeRouteTodayAgg->distinct()->select(
            'dse_route as id_user',
            'distributor.title AS distributor_title',
            'rpt_sales_productivity_agg.tot as total_order_value',
            DB::raw("SUM(schedule_call) as schedule_call"),
            DB::raw("SUM(call_made) as call_made "),
            DB::raw("SUM(successfull_call) as sucessful_call"),
            DB::raw("SUM(call_not_performed) as call_not_performed"),
            DB::raw("ABS((SUM(successfull_call) - SUM(call_made)))  as unsucessful_call"),
            DB::raw("ROUND(((sum(successfull_call)/sum(call_made)) * 100),2)  as productivity"),
            DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title")
    )
            ->leftJoin('user', 'user.id_user', '=', 'rpt_active_route_agg.dse_route')
            ->leftJoin('distributor', 'distributor.id_distributor', '=', 'rpt_active_route_agg.distributor_id')
            ->leftjoin(
                DB::raw("
        (SELECT
        town_id,
            user_id,
            distributor_id,
            business_unit_id,
            SUM(order_value) AS tot
    FROM
        rpt_sales_productivity_agg
    WHERE
        `rpt_sales_productivity_agg`.`transaction_dt` >= '$start_date'
            AND `rpt_sales_productivity_agg`.`transaction_dt` <= '$end_date'
            AND phone_order = 0
    GROUP BY town_id , user_id , distributor_id , business_unit_id )rpt_sales_productivity_agg
         "), 'rpt_sales_productivity_agg.user_id', '=', 'rpt_active_route_agg.dse_route',
                'rpt_sales_productivity_agg.distributor_id', '=', 'rpt_active_route_agg.distributor_id',
                'rpt_sales_productivity_agg.business_unit_id', '=', 'rpt_active_route_agg.business_unit_id'
            );

        $sql->orderby('productivity', 'desc')
            ->groupby('dse_route')
            ->filtered()->where('rpt_active_route_agg.phone_order', '=', '0')
            ->groupby('dse_route');
        if (isset($productivity)) {
            $sql->havingRaw("sum(successfull_call)/sum(call_made) >= $productivity");
        }
        if (isset($start_date)) {
            $sql->where('rpt_active_route_agg.transaction_dt', '>=', $start_date);
        }
        if (isset($end_date)) {
            $sql->where('rpt_active_route_agg.transaction_dt', '<=', $end_date);
        }
        if (!empty($data['user_id'])) {
            $sql->whereIn('rpt_active_route_agg.dse_route', $data['user_id']);
        }
        /***
         * $group_flag was added for viewing the dse productivity on daily Basis based on the date filter
         */
        if (isset($groupFlag)) {
            $sql->leftJoin('route', 'rpt_active_route_agg.route_id', '=', 'route.id_route')
                ->addSelect('route.title as route_title', 'rpt_active_route_agg.transaction_dt')
                ->groupby('rpt_active_route_agg.transaction_dt')
                ->groupby('rpt_active_route_agg.route_id')
                ->orderby('rpt_active_route_agg.dse_route');
        }
        if (isset($limit)) {
          //  $callInfo = $sql->get()->toArray();
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }
        return $callInfo;
    }


    public function dseProductivityReport($data)
    {
        $limit = null;
        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }
        if (isset($data['productivity'])) {
            $productivity = $data['productivity'];
        }
        $sql = $this->activeRouteToday->select('route.title as route_title',
            'dse_route as user_id',
            'route.title as route_title',
            'town.title as town_title', 'route.id_route',
            'distributor.title AS distributor_title',
            'schedule_call AS schedule_call',
            'call_made AS call_made',
            'call_not_performed AS call_not_performed',
            'successfull_call AS sucessful_call',
            DB::raw("ABS(successfull_call - call_made)  as unsucessful_call"),
            DB::raw("ROUND(((successfull_call/call_made) * 100),2)  as productivity"),
            DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"),
            DB::raw("SUM(order_value) as total_order_value")
        )
            ->join('rpt_sales_productivity_today', function ($q) {
                $q->on('rpt_sales_productivity_today.route_id', '=', 'rpt_active_route_today.route_id');
                $q->on('rpt_sales_productivity_today.user_id', '=', 'rpt_active_route_today.dse_route');
                $q->on('rpt_sales_productivity_today.distributor_id', '=', 'rpt_active_route_today.distributor_id');
                $q->on('rpt_sales_productivity_today.transaction_dt', '=', 'rpt_active_route_today.transaction_dt');
                $q->on('rpt_sales_productivity_today.business_unit_id', '=', 'rpt_active_route_today.business_unit_id');
                $q->on('rpt_sales_productivity_today.phone_order', '=', 'rpt_active_route_today.phone_order');
            })
            ->leftJoin('user', 'user.id_user', '=', 'rpt_active_route_today.dse_route')
            ->leftJoin('route', 'rpt_active_route_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'route.town_id', '=', 'town.id_town')
            ->leftJoin('distributor', 'distributor.id_distributor', '=', 'rpt_active_route_today.distributor_id')
            ->groupby('dse_route')
            ->groupby('rpt_active_route_today.route_id')
            ->orderby('productivity', 'desc')
            ->filtered()->where('rpt_active_route_today.phone_order', '=', '0');
        if (isset($productivity)) {
            $sql->where(DB::raw("successfull_call/call_made"), '>=', $productivity);
        }
        if (!empty($data['user_id'])) {
            $sql->whereIn('rpt_active_route_today.dse_route', $data['user_id']);
        }
        if (isset($limit)) {
            $callInfo = $sql->paginate($limit)->toArray();
        } else {
            // Only for the download section....
            $callInfo = $sql->get()->toArray();
        }
        // dd($callInfo);
        return $callInfo;
    }

    public function getDetailOfActiveDseRouteRetailOutlet($data)
    {

        if (isset($data['user_id'])) {
            $user = $data['user_id'];
        }
        if (isset($data['route_id'])) {
            $route = $data['route_id'];
        }
        $sql = $this->activeRouteToday
            ->leftJoin('user', 'user.id_user', '=', 'rpt_active_route_today.dse_route')
            ->leftJoin('distributor', 'distributor.id_distributor', '=', 'rpt_active_route_today.distributor_id')
            ->leftJoin('route', 'rpt_active_route_today.route_id', '=', 'route.id_route')
            ->leftJoin('town', 'rpt_active_route_today.town_id', '=', 'town.id_town')
            ->leftJoin('route_retail_outlet', 'route_retail_outlet.route_id', '=', 'route.id_route')
            ->leftJoin('retail_outlet', 'route_retail_outlet.retail_outlet_id', '=', 'retail_outlet.id_retail_outlet')
            ->leftJoin('rpt_route_productivity_today', 'rpt_route_productivity_today.retail_outlet_id', '=',
                'retail_outlet.id_retail_outlet')
            ->distinct()
            ->select('route_retail_outlet.retail_outlet_id', 'route.title as route_title',
                'retail_outlet.title as retail_outlet_title', 'sucessful_call', 'unsucessful_call',
                'town.title as town_title', 'distributor.title AS distributor_title', 'route.id_route',
                DB::raw("CONCAT(user.first_name, ' ',user.last_name) as user_title"))
            ->orderby('id_route', 'asc')
            ->orderby('sucessful_call', 'desc')
            ->orderby('unsucessful_call', 'desc')
            ->filtered();//->where('rpt_route_productivity_today.phone_order','=','0');
        if (isset($user)) {
            $sql->where('rpt_active_route_today.dse_route', '=', $user);
        }
        if (isset($route)) {
            $sql->where('rpt_active_route_today.route_id', '=', $route);
        }

        // Only for the download section....
        $callInfo = $sql->get()->toArray();

        return $callInfo;
    }

    /**************************************/

    public function getAllOrderStatusCountWithAmount()
    {
        //$start_date = date('Y-m-d') . ' 00:00:00';
        //$end_date = date('Y-m-d') . ' 23:59:59';
        $selectListSql = array(
            'order_status_id',
            //DB::raw("COUNT(id_sales_order) as count_order"),
            DB::raw("sum(order_value) as npr_price")
        );
        $orderValue = $this->salesProductivityToday->select($selectListSql)
            ->filtered()->groupBy('order_status_id')->get();

        //  dd($orderValue[]);
        return $orderValue;
    }

    public function getTodayOrderStatusCountWithAmount()
    {
        $start_date = date('Y-m-d') . ' 00:00:00';
        $end_date = date('Y-m-d') . ' 23:59:59';
        $selectListSql = array(
            'order_status_id',
            //DB::raw("COUNT(id_sales_order) as count_order"),
            DB::raw("sum(order_value) as npr_price")
        );
        $orderValue = $this->salesProductivityToday->select($selectListSql)->where('transaction_dt', '>=', $start_date)
            ->where('transaction_dt', '<=', $end_date)->filtered()->groupBy('order_status_id')->get();
        return $orderValue;
    }


    public function getNationalReportMonthly()
    {
        $sql = $this->routeProductivityAgg
            ->select(DB::raw('count(distinct(user_id)) as dse'),
                DB::raw('count(distinct(retail_outlet_id)) as call_made'),
                DB::raw('COUNT(IF(unsucessful_call=1,1,NULL))  as unsucessful_call'),
                DB::raw('COUNT(IF(sucessful_call=1,1,NULL)) as sucessful_call'))
            ->filtered();
        $sql->orderBy('transaction_dt', 'desc');
        $sql->whereRaw(DB::raw("transaction_dt > ( now() - interval 1 month) and transaction_dt <now()"));


        $monthly_data = $sql->get()->toArray();


        return $monthly_data;
    }

    public function getNationalReportRouteMonthly()
    {

        $sql = $this->activeRouteTodayAgg
            ->select(DB::raw('sum(schedule_call) as route_schedule'),
                DB::raw('sum(call_made) as route_call_made'),
                DB::raw('sum(call_not_performed) as call_not_performed'),
                DB::raw('sum(successfull_call) as route_sucessful_call'))
            ->filtered()
            ->orderBy('transaction_dt', 'desc')
            ->whereRaw(DB::raw("transaction_dt > ( now() - interval 1 month) and transaction_dt <now()"));
        $monthly_route_data = $sql->get()->toArray();
        return $monthly_route_data;
    }

    public function getAllOrderStatusCountWithAmountMonthly()
    {
        //$start_date = date('Y-m-d') . ' 00:00:00';
        //$end_date = date('Y-m-d') . ' 23:59:59';
        $selectListSql = array(
            'order_status_id',
            //DB::raw("COUNT(id_sales_order) as count_order"),
            DB::raw("sum(order_value) as npr_price")
        );
        $orderValue = $this->salesProductivityAgg->select($selectListSql)
            ->filtered()->groupBy('order_status_id')
            ->orderBy('transaction_dt', 'desc')
            ->whereRaw(DB::raw("transaction_dt > ( now() - interval 1 month) and transaction_dt <now()"))->get()->toArray();

        return $orderValue;
    }
    //
    /**
     *  SELECT
     * successfull_call / call_made AS productivity,
     * CONCAT(user.first_name, ' ', user.last_name) AS title,
     * `route_id`,
     * `dse_route`
     * FROM
     * `rpt_active_route_today`
     * LEFT JOIN
     * `user` ON `user`.`id_user` = `rpt_active_route_today`.`dse_route`
     * where (successfull_call / call_made) >= .5
     * GROUP BY `rpt_active_route_today`.`dse_route`
     * order by productivity
     * LIMIT 5
     */

    public function getOrderStatusCountWithAmount()
    {
        return $this->repository->getOrderStatusCountWithAmount();
    }


    public function getActiveRetailOutlet()
    {
        $keyArray = array('total', 'success', 'unsuccess', 'callNotPerformed');
        $countArray = array();

        $sales = $this->repository->getSalesOrderRoCount();
        $successCall = $sales[0]['sales'];
        $noorder = $this->noOrderRepository->getNoOrderRoCount();
        $unSuccessCall = $noorder[0]['sales'];

        $new = array_merge($sales, $noorder);

        $salesRO = $this->repository->getSalesOrderRo();
        $nosalesRO = $this->noOrderRepository->getNoOrderRo();
        $newRO = array_merge($salesRO, $nosalesRO);
        $roArray = array();
        // dump($salesRO);
        foreach ($newRO as $item) {
            $roArray[] = $item['retail_outlet_id'];
        }

        $activeRO = $this->routeRepository->getOverallROActiveRoute($roArray);
        $activeRO = (array)$activeRO;
        $countActiveRo = $activeRO[0]->ro_count_order;
        $sum = 0;
        foreach ($new as $item) {
            $sum += $item['sales'];

        }
        $callNotPerformed = 0;
        if ($countActiveRo && $sum) {
            $callNotPerformed = (int)$countActiveRo - (int)$sum;
        }

        array_push($countArray, $sum, $successCall, $unSuccessCall, $callNotPerformed);
        for ($i = 0; $i < sizeof($keyArray); $i++) {
            $allArray[$keyArray[$i]] = $countArray[$i];
        }
        return $allArray;
    }

    public function getActiveSalesRepresentative()
    {
        $new_old = array();
        $sales = $this->repository->getSalesDSE();
        $noorder = $this->noOrderRepository->getNoOrderDSE();
        $new = array_merge($sales, $noorder);
        foreach ($new as $item) {
            $new_old[] = $item['sales_representative_id'];

        }
        $uniqueArray = array_unique($new_old);
        return count($uniqueArray);

    }

    public function getSummaryReport()
    {
        $selectData = array(
            DB::raw('COUNT(IF(phone_order=0 and order_status_id = 1,a.route_id,NULL))  as active_route'),
            DB::raw('SUM(IF(phone_order=0 and order_status_id = 1,a.schedule_call,0))  as schedule_call'),
            DB::raw('SUM(IF(phone_order=0 and order_status_id = 1,a.successfull_call,0))  as successfull_call'),
            DB::raw('SUM(IF(phone_order=0 and order_status_id = 1,a.call_not_performed,0))  as call_not_performed'),
            DB::raw('SUM(IF(phone_order=0 and order_status_id = 1,a.call_made,0))  as call_made'),
            //DB::raw("count(a.route_id) as active_route"),
            // DB::raw("select (SUM(a.call_mades) - SUM(a.successfull_calls)) AS unsucessful_call"),
            DB::raw("GROUP_CONCAT(CONCAT(order_status_id, ',', (total_order_value))
                      ORDER BY order_status_id , total_order_value
                     SEPARATOR ',') as total_order_value"),
            'a.town_id',
            'a.town_title',
            'a.distributor_id',
            'a.distributor_title',
            'zone_title',
            'zone_id'
        );

        $active_order = $this->activeRouteToday->select('rpt_sales_productivity_today.town_id',
            'rpt_sales_productivity_today.distributor_id',
            'rpt_active_route_today.schedule_call',
            'rpt_sales_productivity_today.route_id',
            'rpt_active_route_today.successfull_call',
            'rpt_active_route_today.call_not_performed',
            'rpt_active_route_today.call_made',
            'distributor.title as distributor_title',
            'town.title as town_title',
            'geographic_location.title as zone_title',
            'geographic_location.id_geographic_location as zone_id',
            'rpt_sales_productivity_today.phone_order',
            //'rpt_active_route_today.created_at',
            'rpt_sales_productivity_today.order_status_id',
            DB::raw("SUM(order_value) as total_order_value"))
            ->rightjoin('rpt_sales_productivity_today', function ($q) {
                $q->on('rpt_sales_productivity_today.route_id', '=', 'rpt_active_route_today.route_id');
                $q->on('rpt_sales_productivity_today.user_id', '=', 'rpt_active_route_today.dse_route');
                $q->on('rpt_sales_productivity_today.distributor_id', '=', 'rpt_active_route_today.distributor_id');
                $q->on('rpt_sales_productivity_today.transaction_dt', '=', 'rpt_active_route_today.transaction_dt');
                $q->on('rpt_sales_productivity_today.business_unit_id', '=', 'rpt_active_route_today.business_unit_id');
            })
            ->leftJoin('town', 'rpt_sales_productivity_today.town_id', '=', 'town.id_town')
            ->leftJoin('geographic_location_town', 'geographic_location_town.town_id', '=', 'town.id_town')
            ->leftJoin('geographic_location', 'geographic_location.id_geographic_location', '=',
                'geographic_location_town.geographic_location_id')
            ->leftJoin('distributor', 'distributor.id_distributor', '=', 'rpt_sales_productivity_today.distributor_id')
            ->groupBy('rpt_sales_productivity_today.route_id')
            ->groupBy('rpt_sales_productivity_today.order_status_id')->filtered();

        $no_order_sql = $this->activeRouteToday->select(
            'rpt_active_route_today.town_id',
            'rpt_active_route_today.distributor_id',
            'rpt_active_route_today.schedule_call',
            'rpt_active_route_today.route_id',
            'rpt_active_route_today.successfull_call',
            'rpt_active_route_today.call_not_performed',
            'rpt_active_route_today.call_made',
            //'1',
            //DB::raw(("select 1 as order_status_id")),
            //'1 AS order_status_id',
            'distributor.title AS distributor_title',
            'town.title AS town_title',
            'geographic_location.title AS zone_title',
            'geographic_location.id_geographic_location AS zone_id',
            'rpt_active_route_today.phone_order'
        )
            ->selectRaw('(select 1) as order_status_id')
            ->selectRaw('(select 0) as total_order_value')
            ->leftJoin('town', 'rpt_active_route_today.town_id', '=', 'town.id_town')
            ->leftJoin('geographic_location_town', 'geographic_location_town.town_id', '=', 'town.id_town')
            ->leftJoin('geographic_location', 'geographic_location.id_geographic_location', '=',
                'geographic_location_town.geographic_location_id')
            ->leftJoin('distributor', 'distributor.id_distributor', '=', 'rpt_active_route_today.distributor_id')
            ->where('phone_order', '=', '0')
            ->where('successfull_call', '=', '0')
            ->groupBy('rpt_active_route_today.route_id')->filtered();


        $sqlRaw = $active_order->union($no_order_sql);
        $sql = $sqlRaw->toSql();
        $res = DB::table(DB::raw("($sql) AS a"))->select($selectData)
            // ->selectRaw('(select (call_mades) -  (successfull_calls)) as roCount')
            ->groupBy('a.town_id')
            ->groupBy('a.distributor_id')
            //  ->groupBy('a.status')
            ->orderBy('a.town_id')->setBindings($sqlRaw->getBindings())->get();

        return $res;

    }


    public function getSummaryReportAggregate($data)
    {

        if (!empty($data['filter']['start_date'])) {
            $start_date = $data['filter']['start_date'] . ' 00:00:00';;
        }
        if (!empty($data['filter']['end_date'])) {
            $end_date = $data['filter']['end_date'] . ' 23:59:59';
        }

        $selectData = array(
            DB::raw('COUNT(IF(phone_order=0 and order_status_id = 1,a.route_id,NULL))  as active_route'),
            DB::raw('SUM(IF(phone_order=0 and order_status_id = 1,a.schedule_call,0))  as schedule_call'),
            DB::raw('SUM(IF(phone_order=0 and order_status_id = 1,a.successfull_call,0))  as successfull_call'),
            DB::raw('SUM(IF(phone_order=0 and order_status_id = 1,a.call_not_performed,0))  as call_not_performed'),
            DB::raw('SUM(IF(phone_order=0 and order_status_id = 1,a.call_made,0))  as call_made'),
            //DB::raw("count(a.route_id) as active_route"),
            // DB::raw("select (SUM(a.call_mades) - SUM(a.successfull_calls)) AS unsucessful_call"),
            DB::raw("GROUP_CONCAT(CONCAT(order_status_id, ',', (total_order_value))
                      ORDER BY order_status_id , total_order_value
                     SEPARATOR ',') as total_order_value"),
            'a.town_id',
            'a.town_title',
            'a.distributor_id',
            'a.distributor_title',
            'zone_title',
            'zone_id'//,'created_at'
        );
        $active_order = $this->activeRouteTodayAgg->select('rpt_sales_productivity_agg.town_id',
            'rpt_sales_productivity_agg.distributor_id',
            'rpt_active_route_agg.schedule_call',
            'rpt_active_route_agg.route_id',
            'rpt_active_route_agg.successfull_call',
            'rpt_active_route_agg.call_not_performed',
            'rpt_active_route_agg.call_made',
            'distributor.title as distributor_title',
            'town.title as town_title',
            'geographic_location.title as zone_title',
            'geographic_location.id_geographic_location as zone_id',
            'rpt_sales_productivity_agg.phone_order',
            //'rpt_active_route_agg.created_at',
            'rpt_sales_productivity_agg.order_status_id',
            DB::raw("SUM(order_value) as total_order_value"))
            ->rightjoin('rpt_sales_productivity_agg', function ($q) {
                $q->on('rpt_sales_productivity_agg.route_id', '=', 'rpt_active_route_agg.route_id');
                $q->on('rpt_sales_productivity_agg.user_id', '=', 'rpt_active_route_agg.dse_route');
                $q->on('rpt_sales_productivity_agg.distributor_id', '=', 'rpt_active_route_agg.distributor_id');
                $q->on('rpt_sales_productivity_agg.transaction_dt', '=', 'rpt_active_route_agg.transaction_dt');
                $q->on('rpt_sales_productivity_agg.business_unit_id', '=', 'rpt_active_route_agg.business_unit_id');
            })
            ->leftJoin('town', 'rpt_sales_productivity_agg.town_id', '=', 'town.id_town')
            ->leftJoin('geographic_location_town', 'geographic_location_town.town_id', '=', 'town.id_town')
            ->leftJoin('geographic_location', 'geographic_location.id_geographic_location', '=',
                'geographic_location_town.geographic_location_id')
            ->leftJoin('distributor', 'distributor.id_distributor', '=', 'rpt_sales_productivity_agg.distributor_id')
            ->where('rpt_active_route_agg.created_at', '>=', $start_date)
            ->where('rpt_active_route_agg.created_at', '<=', $end_date)
            ->groupBy('rpt_active_route_agg.route_id')
            ->groupBy('rpt_sales_productivity_agg.town_id')
            ->groupBy('rpt_sales_productivity_agg.distributor_id')
            ->groupBy('geographic_location.id_geographic_location')
            ->groupBy('rpt_sales_productivity_agg.order_status_id')->filtered(); //->getBindings();

        $no_order_sql = $this->activeRouteTodayAgg->select(
            'rpt_active_route_agg.town_id',
            'rpt_active_route_agg.distributor_id',
            'rpt_active_route_agg.schedule_call',
            'rpt_active_route_agg.route_id',
            'rpt_active_route_agg.successfull_call',
            'rpt_active_route_agg.call_not_performed',
            'rpt_active_route_agg.call_made',
            'distributor.title AS distributor_title',
            'town.title AS town_title',
            'geographic_location.title AS zone_title',
            'geographic_location.id_geographic_location AS zone_id',
            'rpt_active_route_agg.phone_order'
        )
            ->selectRaw('(select 1) as order_status_id')
            ->selectRaw('(select 0) as total_order_value')
            ->leftJoin('town', 'rpt_active_route_agg.town_id', '=', 'town.id_town')
            ->leftJoin('geographic_location_town', 'geographic_location_town.town_id', '=', 'town.id_town')
            ->leftJoin('geographic_location', 'geographic_location.id_geographic_location', '=',
                'geographic_location_town.geographic_location_id')
            ->leftJoin('distributor', 'distributor.id_distributor', '=', 'rpt_active_route_agg.distributor_id')
            ->where('phone_order', '=', '0')
            ->where('successfull_call', '=', '0')
            ->where('rpt_active_route_agg.created_at', '>=', $start_date)
            ->where('rpt_active_route_agg.created_at', '<=', $end_date)
            ->groupBy('rpt_active_route_agg.route_id')->filtered();

        $sqlRaw = $active_order->union($no_order_sql);

        $sql = $sqlRaw->toSql();
        $res = DB::table(DB::raw("($sql) AS a"))->select($selectData)
            // ->selectRaw('(select (call_mades) -  (successfull_calls)) as roCount')
            ->groupBy('a.town_id')
            ->groupBy('a.distributor_id')
            ->orderBy('a.town_id')->setBindings($sqlRaw->getBindings())->get();

        return $res;
    }


    public function getChannelCategoryWiseReport($data, $flag)
    {
        $start_date = $data['start'] . ' 00:00:00';
        $end_date = $data['end'] . ' 23:59:59';
        $thisModel = $this->salesProductivityAgg;
        if ($flag == true) {
            $thisModel = $this->salesProductivityToday;
        }
        $result = $thisModel->select(
            'catalog_detail.title as brand',
            'id_category',
            'id_channel',
            'distributor.title AS distributor',
            // 'sku.title AS sku',
            'category.title AS category',
            'channel.title AS channel',
            'town.title AS town',
            'geographic_location.title AS zone',
            DB::raw('SUM(qty) AS quantity'),
            DB::raw('SUM(order_value) AS amount')
        // DB::raw("CONCAT(user.first_name, ' ',user.last_name) as DSE"),
        //  DB::raw("CONCAT(parent.first_name, ' ', parent.last_name) as STL")
        )->leftjoin('ku', 'sku.id_sku', '=', $thisModel->getTable() . '.sku_id')
            ->leftjoin('catalog_sku', 'catalog_sku.sku_id', '=', $thisModel->getTable() . '.sku_id')
            ->leftjoin('catalog_detail', 'catalog_detail.id_catalog_detail', '=', 'catalog_sku.catalog_detail_id')
            ->leftjoin('retail_outlet_category', 'retail_outlet_category.retail_outlet_id', '=',
                $thisModel->getTable() . '.retail_outlet_id')
            ->leftjoin('category', 'category.id_category', '=', 'retail_outlet_category.category_id')
            ->leftjoin('channel', 'category.channel_id', '=', 'channel.id_channel')
            ->leftjoin('distributor', 'distributor.id_distributor', '=', 'channel.distributor_id')
            ->leftjoin('retail_outlet', 'retail_outlet.retail_outlet_id', '=',
                $thisModel->getTable() . '.retail_outlet_id')
            ->leftjoin('town', 'retail_outlet.town_id', '=', 'town.id_town')
            ->leftjoin('geographic_location_town', 'town.id_town', '=', 'geographic_location_town.town_id')
            ->leftjoin('geographic_location', 'geographic_location.id_geographic_location', '=',
                'geographic_location_town.geographic_location_id')
            // ->leftjoin('user', 'user.id_user', '=', $thisModel->getTable() . '.user_id')
            //  ->leftjoin('user as parent', 'parent.id_user', '=', 'user.parent_user_id')
            ->where('catalog_id', '3')
            ->where('order_status_id', '3')
            ->where('transaction_dt', '>=', $start_date)
            ->where('transaction_dt', '<=', $end_date)
            ->groupBy('catalog_detail.id_catalog_detail')
            ->groupBy('category.id_category')
            ->groupBy('id_town')
            ->groupBy('id_geographic_location')->get();
        return $result;
    }

}