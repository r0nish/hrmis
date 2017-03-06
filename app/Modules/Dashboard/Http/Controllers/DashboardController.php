<?php
/**
 * Created by PhpStorm.
 * User: binita
 * Date: 8/22/16
 * Time: 3:09 PM
 */

namespace Modules\Dashboard\Http\Controllers;


use App\APIHelpers\Transformers\DashboardSummaryTransformer;
use App\APIHelpers\Transformers\DashboardTransformer;
use App\APIHelpers\Transformers\SalesReportTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Modules\Configure\Entities\Channel;
use Modules\Configure\Services\Universe\Outlets\ChannelService;
use Modules\Dashboard\Services\DashboardService;
use Modules\Foundation\Controllers\AbstractController;
use Modules\User\Services\UserService;
use Modules\Sales\Services\OrderProcessing\Orders\SalesOrderService;


class DashboardController extends AbstractController
{

    protected $service;
    protected $dashboardTransformer;
    protected $dashboardSummaryTransformer;
    protected $userService;
    protected $salesOrderService;
    protected $salesReportTransformer;
    protected $channelService;

    public function __construct(
        DashboardService $service,
        DashboardTransformer $dashboardTransformer,
        DashboardSummaryTransformer $dashboardSummaryTransformer,
        UserService $userService,
        SalesOrderService $salesOrderService,
        SalesReportTransformer $salesReportTransformer,
        ChannelService $channelService
    ) {
        $this->service = $service;
        $this->dashboardTransformer = $dashboardTransformer;
        $this->dashboardSummaryTransformer = $dashboardSummaryTransformer;
        $this->userService = $userService;
        $this->salesOrderService = $salesOrderService;
        $this->salesReportTransformer = $salesReportTransformer;
        $this->channelService = $channelService;
    }

    public function getDashBoardReport()
    {
        $query = null;
        $flag = true;
        $orderValueAll = array();
        $allDseData = 0;
        $orderValueToday = array();
        $result = $this->service->getNationalReport();
        $result_route = $this->service->getNationalReportRoute();
        //$result_dse = $this->service->getTopFiveDSE();
        $oderValue = $this->service->getAllOrderStatusCountWithAmount();
        $offlineCall = $this->service->getOfflineCall();
        $allDse = $this->userService->getAllDseUser();
        foreach ($oderValue as $key => $val) {

            $orderValueAll[] = $val['attributes'];
        }
        $orderValueII = $this->service->getTodayOrderStatusCountWithAmount();
        foreach ($orderValueII as $key => $val) {

            $orderValueToday[] = $val['attributes'];
        }

        if (!empty($allDse)) {
            $allDseData = $allDse[0]['tot_dse'];
        }
//        $orderReceived = $this->service->getOrderReceivedValue();
//        $orderInvoiced = $this->service->getOrderInvoiceValue();
//
//        if (!empty($orderReceived)) {
//            $orderReceived = $orderReceived['order_received'];
//        }
//        if (!empty($orderInvoiced)) {
//            $orderInvoiced = $orderInvoiced['order_invoiced'];
//        }
//        foreach ($result_dse as $key => $val) {
//            $topFiveDse[] = $result_dse[$key]['title'] . ',' . $result_dse[$key]['productivity'];
//        }

        $roCount = 0;
        $callNotPerformed = 0;
        $productivity = 0;
        if (!empty($result)) {
            $roCount = $result[0]['call_made'];
            $unSuccessCall = $result[0]['unsucessful_call'];
            $successCall = $result[0]['sucessful_call'];
            $activeDse = $result[0]['dse'];
        }
        if (!empty($result_route)) {
            $route_schedule = $result_route[0]['route_schedule'];
            $route_call_made = $result_route[0]['route_call_made'];
            $totalSuccessCall = $result_route[0]['route_sucessful_call'];
            $callNotPerformed = $result_route[0]['call_not_performed'];
            $active_route = $result_route[0]['active_route'];
            if ($route_call_made != 0) {
                $productivity = ((int)$totalSuccessCall / (int)$route_call_made) * 100;
            }
        }

        // $countWithPrice = $this->service->getOrderStatusCountWithAmount();
        return $this->respond([
            //'dataWithPrice'     =>$countWithPrice,
            'dataRoCount' => $roCount,
            'activeRoute' => $active_route,
            'dataDSE' => $activeDse,
            'allDse' => $allDseData,
            'scheduleCall' => $route_schedule,
            'dataUnsuccessCall' => $unSuccessCall,
            'datasuccessCall' => $totalSuccessCall,
            'dataProductivity' => $productivity,
            'dataCallNotPerformed' => $callNotPerformed,
            'dataCallMade' => $route_call_made,
            'offlineCall' => $offlineCall[0]['off_call'],
            // 'dataTopFiveDseWithProductivity' => $topFiveDse,
            // 'dataTopFiveDseWithVol' => $topFiveVol,
            // 'dataOrderReceived' =>$orderReceived,
            // 'dataOrderInvoiced' =>$orderInvoiced,
            // 'dataOrderDispatched' =>0,
            'orderValueAll' => $orderValueAll,
            'orderValueToday' => $orderValueToday,

        ]);
    }


    /***
     * Get the detail of offline call
     * @param Request $request
     * @return mixed
     */

    public function getDetailOfflineRouteRetailOutlet(Request $request)
    {
        $data = $request->input();
        $restrictions = [];
        $callInfo = $this->service->getDetailOfflineRouteRetailOutlet($data);
        return $this->respond([
            'total' => $callInfo ['total'],
            'current_page' => $callInfo ['current_page'],
            'last_page' => $callInfo ['last_page'],
            'data' => $this->dashboardTransformer->transformCollection($callInfo['data'], $restrictions),
            'permissions' => $restrictions
        ]);
    }

    public function getDashBoardMonthlyReport()
    {
        $topFiveDse = array();
        $topFiveVol = array();
        $orderValueAll = array();
        $orderValueToday = array();
        $result = $this->service->getNationalReportMonthly();
        $result_route = $this->service->getNationalReportRouteMonthly();
//        $result_dse = $this->service->getTopFiveDSEMonthly();
        $oderValue = $this->service->getAllOrderStatusCountWithAmountMonthly();
        foreach ($oderValue as $key => $val) {

            $orderValueAll[] = $val['attributes'];
        }
    }


    public function getDetailViewReports($request)
    {

        if ($request['dashboard'] == 'activeDse') {
            $rpt = $this->getDetailOfActiveDse();
        } else {
            if ($request['dashboard'] == 'unsuccess') {
                $rpt = $this->getDetailOfUnSuccessFullCall();
            } else {
                if ($request['dashboard'] == 'scheduled') {
                    $rpt = $this->getDetailOfScheduledCall();
                } else {
                    if ($request['dashboard'] == 'success') {
                        $rpt = $this->getDetailOfSuccessFullCall();
                    } else {
                        if ($request['dashboard'] == 'callMade') {
                            $rpt = $this->getDetailOfCallMade();
                        } else {
                            if ($request['dashboard'] == 'callNotPerformed') {
                                $rpt = $this->getCallNotPerformedDetail();
                            }
                        }
                    }
                }
            }
        }
        return $rpt;
    }


    public function getDetailOfActiveDse(Request $request)
    {
        $data = $request->input();
        $restrictions = [];
        $dseInfo = $this->service->getDetailOfActiveDse($data);
        return $this->respond([
            'total' => $dseInfo ['total'],
            'current_page' => $dseInfo ['current_page'],
            'last_page' => $dseInfo ['last_page'],
            'data' => $this->dashboardTransformer->transformCollection($dseInfo['data'], $restrictions),
            'permissions' => $restrictions
        ]);
    }


    public function getDetailOfActiveDseRouteRetailOutlet(Request $request)
    {
        $data = $request->input();
        $restrictions = [];
        $callInfo = $this->service->getDetailOfActiveDseRouteRetailOutlet($data);
        return $this->respond([
            'data' => $this->dashboardTransformer->transformCollection($callInfo, $restrictions),

        ]);
    }


    public function getDetailOfScheduledCall(Request $request)
    {
        $data = $request->input();
        $callInfo = $this->service->getDetailOfScheduledCall($data);
        $restrictions = [];
        return $this->respond([
            'total' => $callInfo ['total'],
            'current_page' => $callInfo ['current_page'],
            'last_page' => $callInfo ['last_page'],
            'data' => $this->dashboardTransformer->transformCollection($callInfo['data'], $restrictions),
            'permissions' => $restrictions
        ]);
    }

    public function getScheduleRouteRetailOutlet(Request $request)
    {
        $data = $request->input();
        $permission = [];
        $scheduledCall = $this->service->getScheduleRouteRetailOutlet($data);
        return $this->respond([
            'data' => $this->dashboardTransformer->transformCollection($scheduledCall, $permission),

        ]);
    }


    public function getDetailOfSuccessFullCall(Request $request)
    {
        $data = $request->input();
        $callInfo = $this->service->getDetailOfSuccessFullCall($data);
        $restrictions = [];
        return $this->respond([
            'total' => $callInfo ['total'],
            'current_page' => $callInfo ['current_page'],
            'last_page' => $callInfo ['last_page'],
            'data' => $this->dashboardTransformer->transformCollection($callInfo['data'], $restrictions),
            'permissions' => $restrictions
        ]);
    }


    public function getSuccessfulRouteRetailOutlet(Request $request)
    {
        $data = $request->input();
        $permission = [];
        $callInfo = $this->service->getSuccessfulRouteRetailOutlet($data);
        return $this->respond([
            'data' => $this->dashboardTransformer->transformCollection($callInfo, $permission),

        ]);
    }

    public function getUnSuccessfulRouteRetailOutlet(Request $request)
    {
        $data = $request->input();
        $permission = [];
        $callInfo = $this->service->getUnSuccessfulRouteRetailOutlet($data);
        return $this->respond([
            'data' => $this->dashboardTransformer->transformCollection($callInfo, $permission),

        ]);
    }

    //getUnSuccessfulRouteRetailOutlet

    public function getDetailOfUnSuccessFullCall(Request $request)
    {
        $data = $request->input();

        $permission = [];
        $callInfo = $this->service->getDetailOfUnSuccessFullCall($data);
        $restrictions = [];
        return $this->respond([
            'total' => $callInfo ['total'],
            'current_page' => $callInfo ['current_page'],
            'last_page' => $callInfo ['last_page'],
            'data' => $this->dashboardTransformer->transformCollection($callInfo['data'], $restrictions),
            'permissions' => $restrictions
        ]);
    }

    public function getDetailOfCallMade(Request $request)
    {
        $data = $request->input();
        $callInfo = null;
        $restrictions = [];
        $callInfo = $this->service->getDetailOfCallMade($data);
        return $this->respond([
            'total' => $callInfo ['total'],
            'current_page' => $callInfo ['current_page'],
            'last_page' => $callInfo ['last_page'],
            'data' => $this->dashboardTransformer->transformCollection($callInfo['data'], $restrictions),
            'permissions' => $restrictions
        ]);
    }

    public function getDetailOfCallMadeRouteRetailOutlet(Request $request)
    {
        $data = $request->input();
        $permission = [];
        $callInfo = $this->service->getDetailOfCallMadeRouteRetailOutlet($data);
        return $this->respond([
            'data' => $this->dashboardTransformer->transformCollection($callInfo, $permission),

        ]);
    }

    public function getCallNotPerformedDetail(Request $request)
    {
        $data = $request->input();
        $restrictions = [];
        $callNotMade = $this->service->getCallNotPerformedDetail($data);
        return $this->respond([
            'total' => $callNotMade ['total'],
            'current_page' => $callNotMade ['current_page'],
            'last_page' => $callNotMade ['last_page'],
            'data' => $this->dashboardTransformer->transformCollection($callNotMade['data'], $restrictions),
            'permissions' => $restrictions
        ]);
    }

    public function getCallNotPerformedRouteRetailOutlet(Request $request)
    {
        $data = $request->input();
        $permission = [];
        $callInfo = $this->service->getCallNotPerformedRouteRetailOutlet($data);
        return $this->respond([
            'data' => $this->dashboardTransformer->transformCollection($callInfo, $permission),

        ]);
    }

    public function dseProductivityReport(Request $request)
    {
        $data = $request->input();
        $restrictions = [];
        $callInfo = $this->service->dseProductivityReport($data);
        // dd($callInfo);
        return $this->respond([
            'total' => $callInfo ['total'],
            'current_page' => $callInfo ['current_page'],
            'last_page' => $callInfo ['last_page'],
            'data' => $this->dashboardTransformer->transformCollection($callInfo['data'], $restrictions),
            'permissions' => $restrictions

        ]);
    }


    public function getSummaryReport(Request $request)
    {
        $data = $request->input();
        $newArray = array();
        $permissionFilters = [];
        $callInfo = $this->service->getSummaryReport($data);
        $callInfo = (array)$callInfo;

        return $this->respond([
            'data' => $this->dashboardSummaryTransformer->transformCollection($callInfo, $permissionFilters),
            //   'data' => $newArray,
        ]);

    }


    public function getSalesSummaryReport(Request $request)
    {
        $channelAllNew = [];
        $permissionFilters = [];
        $arrayAll = [];
        $arrayList = [];
        $data = $request->input();
        $sumData = $this->salesOrderService->getSalesReportForBrandTotal($data);
        foreach ($sumData as $keys => $values) {
            $sumList[$values['channel_id']] = $values;

        }

        $channelAlls = Channel::select('id_channel', 'title')->get()->toArray();
        foreach ($channelAlls as $keys => $values) {
            $channelAll[$values['id_channel']] = $values;

        }
        $dataSet = $this->salesOrderService->getSalesReportForBrand($data);

        $collection = collect($dataSet);
        $collection = $collection->toArray();
        $allData = $this->salesReportTransformer->transformCollection($collection, $permissionFilters);
        foreach ($collection as $key => $value) {
            $zoneList[$value['zone_id']] = $value['zone'];
            $townList[$value['town_id']] = $value['town'];
            $brandList[$value['brand_id']] = $value['brand'];
            $distributorList[$value['distributor_id']] = $value['distributor'];
            $channelList[$value['channel_id']] = $value['channel'];
            $arrayAll[$value['zone_id'] . "_" . $value['town_id'] . "_" . $value['distributor_id'] . "_" . $value['brand_id']][$value['channel_id']][] = $value;
            //$arrayAll[$value['zone_id'] . "_" . $value['town_id'] . "_" . $value['distributor_id'] . "_" . $value['brand_id']."_".$value['channel_id']][] = $value;
            $arrayList[$value['zone_id']][$value['town_id']][$value['distributor_id']][$value['brand_id']][$value['channel_id']][] = $value;
        }
        return view('wwelcome')
            ->with('channelList', $channelAll)
            ->with('zone', $zoneList)
            ->with('town', $townList)
            ->with('brand', $brandList)
            ->with('distributor', $distributorList)
            ->with('channel', $channelList)
            ->with('list', $arrayList)
            ->with('all', $arrayAll)
            ->with('allData', $arrayList)
            ->with('sumData', $sumList);
    }


//    public function getChannelCategoryWiseReport(Request $request)
//    {
//        $permissionFilters = [];
//        $data = $request->input();
//        $data = $this->salesOrderService->getSalesReportForBrand($data);
//        $collection = collect($data);
//        $collection = $collection->toArray();
//        return $this->respond([
//            'data' => $this->salesReportTransformer->transformCollection($collection, $permissionFilters)
//        ]);
//
//    }

    public function getReports(Request $request)
    {

        $reportContent = $this->service->getReports($request->input());
        $reportContent = json_decode(json_encode($reportContent), true);

        if ($reportContent) {

            $filename = 'report-' . time() . '.csv';

            $arrayList = $reportContent;

            $fp = fopen($filename, 'w');

            fputcsv($fp, array_keys($arrayList[0]));


            foreach ($arrayList as $line) {
                fputcsv($fp, $line);
            }

            fclose($fp);

        } else {
            return $this->respondWithError('no file name provided');
        }

        return $this->respond(['data' => 'created file successfully', 'filename' => $filename]);

    }

}