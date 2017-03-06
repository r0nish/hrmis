<?php
    /**
     * Created by PhpStorm.
     * User: binita
     * Date: 2/18/16
     * Time: 12:12 PM
     */

    namespace Modules\ApiLog\Repositories;

    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;
    use Modules\ApiLog\Entities\ApiLogInterface;
    use Modules\Foundation\Repositories\AbstractRepository;
    use Modules\Sales\Entities\SalesOrder;
    use Modules\SBD\Entities\SBDReportDistributionInterface;

    class ApiLogRepository extends AbstractRepository implements ApiLogRepositoryInterface
    {
        protected $model;
        protected $salesOrderModel;

        public function __construct(ApiLogInterface $model)
        {
            $this->model = $model;
            $this->rptSbdDistribution = $this->model->getTable();
        }


        /***
         * Get the  distribution list for  given time period
         *
         * @param $data   (gives the period information)
         * @param $detail (gives the information about the catalog_detail_id and retail_outlet_id )
         *
         * @return mixed
         */

        public function sbdReport($data, $detail)
        {

            $catalogDetailId = null;
            $period = null;
            $retailOutletId = null;
            $categoryId = null;

            if (!empty($data['period_id'])) {
                $period = $data['period_id'];
            }
            if (!empty($detail['catalog_detail_id'])) {
                $catalogDetailId = $detail['catalog_detail_id'];
            }
            if (!empty($detail['retail_outlet_id'])) {
                $retailOutletId = $detail['retail_outlet_id'];
            }
            if (!empty($data['category_id'])) {
                $categoryId = $data['category_id'];
            }
            $selectListSql = [
                'catalog_detail_id',
                'catalog_detail.title',
                DB::raw("count(distinct(sbd_distribution.sku_id)) as available_count")
            ];

            $sql = $this->model->select($selectListSql)
                ->join('sbd_distribution', function ($q) {
                    $q->on('rpt_sbd_distribution.sbd_distribution_id', '=', 'sbd_distribution.id_sbd_distribution');
                    $q->on('rpt_sbd_distribution.sku_id', '=', 'sbd_distribution.sku_id');
                    $q->where('sbd_distribution.status', '=', 1);
                })
                ->join('catalog_sku', 'rpt_sbd_distribution.sku_id', '=', 'catalog_sku.sku_id');
            $sql->join('catalog_detail', function ($q) use ($catalogDetailId) {
                $q->on('catalog_sku.catalog_detail_id', '=', 'catalog_detail.id_catalog_detail')
                    ->where('catalog_id', '=', 3);
                !empty($catalogDetailId) ? $q->where('catalog_detail.catalog_detail_id', '=', $catalogDetailId) : null;
            });
            !empty($retailOutletId) ? $sql->where('rpt_sbd_distribution.retail_outlet_id', '=', $retailOutletId) : null;
            //}
            $sql->groupby('catalog_sku.catalog_detail_id')
                ->orderby('catalog_sku.catalog_detail_id');
            !empty($data) ? $sql->whereIn('sbd_distribution.period_id', $data) : null;
            !empty($categoryId) ? $sql->where('sbd_distribution.category_id', '=', $categoryId) : null;
            $result = $sql->get()->toArray();

            return $result;
        }


        /**
         * Get the detail SKU list for the SBD Distribution
         *
         * @param $data
         * @param $detail
         *
         * @return mixed
         */
        public function getRPTSKUSbdDistribution($data, $detail)
        {
            $catalogDetailId = null;
            $period = null;
            $retailOutletId = null;
            $category = null;

            //   $start_date = $data[0] . ' 00:00:00';
            //  $end_date = $data[1] . ' 23:59:59';

            if (!empty($data['period_id'])) {
                $periodId = $data['period_id'];
            }
            if (!empty($detail['category_id'])) {
                $categoryId = $detail['category_id'];
            }
            if (!empty($detail['retail_outlet_id'])) {
                $retailOutletId = $detail['retail_outlet_id'];
            }
            if (!empty($detail['catalog_detail_id'])) {
                $catalogDetailId = $detail['catalog_detail_id'];
            }
            $selectListSql = [
                'rpt_sbd_distribution.sku_id',
                'sku.title'
            ];
            $sql = $this->model->distinct()->select($selectListSql)
                ->join('sbd_distribution', function ($q) {
                    $q->on('rpt_sbd_distribution.sbd_distribution_id', '=', 'sbd_distribution.id_sbd_distribution');
                    $q->on('rpt_sbd_distribution.sku_id', '=', 'sbd_distribution.sku_id');
                    $q->where('sbd_distribution.status', '=', 1);
                })
                ->join('sku', 'rpt_sbd_distribution.sku_id', '=', 'sku.id_sku')
                ->join('catalog_sku', 'rpt_sbd_distribution.sku_id', '=', 'catalog_sku.sku_id');
            if ($catalogDetailId) {
                $sql->join('catalog_detail', function ($q) use ($catalogDetailId) {
                    $q->on('catalog_sku.catalog_detail_id', '=', 'catalog_detail.id_catalog_detail')
                        ->where('catalog_id', '=', 3);
                    !empty($catalogDetailId) ? $q->where('catalog_detail.id_catalog_detail', '=', $catalogDetailId) : null;
                });
                //// $sql->groupby('catalog_sku.catalog_detail_id');
            }
            !empty($data) ? $sql->whereIn('sbd_distribution.period_id', $data) : null;

//        $sql->where('rpt_sbd_distribution.transaction_date', '>=', $start_date)
//            ->where('rpt_sbd_distribution.transaction_date', '<=', $end_date);
            !empty($retailOutletId) ? $sql->where('rpt_sbd_distribution.retail_outlet_id', '=', $retailOutletId) : null;
            $result = $sql->get()->toArray();

            return $result;
        }


        public function getNationalDistributionReport($data, $detail)
        {
            $catalogDetailId = null;
            $period = null;
            $retailOutletId = null;
            $categoryId = null;
            $townId = null;

            if (!empty($data['period_id'])) {
                $period = $data['period_id'];
            }
            $start_date = $data[0] . ' 00:00:00';
            $end_date = $data[1] . ' 23:59:59';
            if (!empty($detail['catalog_detail_id'])) {
                $catalogDetailId = $detail['catalog_detail_id'];
            }
            if (!empty($detail['retail_outlet_id'])) {
                $retailOutletId = $detail['retail_outlet_id'];
            }
            if (!empty($detail['category_id'])) {
                $categoryId = $detail['category_id'];
            }
            if (!empty($detail['town_id'])) {
                $townId = $detail['town_id'];
            }

            $selectListSql = [
                'rpt_sbd_distribution.retail_outlet_id',
                'retail_outlet.title',
                DB::raw("count(distinct(rpt_sbd_distribution.sku_id)) as available_count")
            ];

            $sql = $this->model->select($selectListSql)
                ->join('retail_outlet', 'retail_outlet.id_retail_outlet', '=', 'rpt_sbd_distribution.retail_outlet_id')
                ->join('retail_outlet_category', 'rpt_sbd_distribution.retail_outlet_id', '=',
                       'retail_outlet_category.retail_outlet_id')
                ->join('catalog_sku', 'rpt_sbd_distribution.sku_id', '=', 'catalog_sku.sku_id');
            if ($catalogDetailId) {
                $sql->join('catalog_detail', function ($q) use ($catalogDetailId) {
                    $q->on('catalog_sku.catalog_detail_id', '=', 'catalog_detail.id_catalog_detail')
                        ->where('catalog_id', '=', 3);
                    !empty($catalogDetailId) ? $q->where('catalog_detail.catalog_detail_id', '=', $catalogDetailId) : null;
                });
                $sql->groupby('catalog_sku.catalog_detail_id');
            }
            $sql->orderby('retail_outlet.id_retail_outlet')
                ->whereNotNull('rpt_sbd_distribution.retail_outlet_id')
                ->where('rpt_sbd_distribution.transaction_date', '>=', $start_date)
                ->where('rpt_sbd_distribution.transaction_date', '<=', $end_date);
            //!empty($data) ? $sql->where('rpt_sbd_distribution.period_id', '=', $data) : null;
            !empty($categoryId) ? $sql->where('retail_outlet_category.category_id', '=', $categoryId) : null;
            !empty($townId) ? $sql->where('retail_outlet.town_id', '=', $townId) : null;

            $result = $sql->get()->toArray();

            return $result;
        }


        /***
         * periously made function
         *
         * @param $data
         * @param $detail
         *
         * @return mixed
         */
        public function sbdReportTest($data, $detail)
        {
            if (!empty($data['period_id'])) {
                $period = $data['period_id'];
            }
            if (!empty($detail['catalog_detail_id'])) {
                $catalogDetailId = $detail['catalog_detail_id'];
            }
            if (!empty($detail['retail_outlet_id'])) {
                $retailOutletId = $detail['retail_outlet_id'];
            }
            if (!empty($detail['category_id'])) {
                $category = $detail['category_id'];
            }
            //$retailOutletId = 1201;
            //$catalogDetailId= 245;

            $selectListSql = [
                'sbd_distribution.period_id',
                'sbd_distribution.sku_id',
                'category_id',
                'sku.title',
                'id_channel as channel_id',
                'category.title as category',
                'channel.title as channel',
                DB::raw("MONTH(transaction_date) as month"),
                DB::raw("YEAR(transaction_date) as year")
            ];

            $sql = $this->model->distinct()->select($selectListSql)
                ->join('sbd_distribution', function ($q) {
                    $q->on('rpt_sbd_distribution.sbd_distribution_id', '=', 'sbd_distribution.id_sbd_distribution');
                    $q->on('rpt_sbd_distribution.sku_id', '=', 'sbd_distribution.sku_id');
                    $q->where('sbd_distribution.status', '=', 1);
                })
                ->join('category', 'sbd_distribution.category_id', '=', 'category.id_category')
                ->join('channel', 'channel.id_channel', '=', 'category.channel_id')
                ->join('sku', 'sku.id_sku', '=', 'rpt_sbd_distribution.sku_id');
            if (isset($catalogDetailId)) {
                $sql->join('catalog_sku', function ($q) use ($catalogDetailId) {
                    $q->on('sku.id_sku', '=', 'catalog_sku.sku_id')
                        ->where('catalog_detail_id', '=', $catalogDetailId);
                });
            }

            if (isset($retailOutletId)) {
                $sql->whereRaw("sbd_distribution.category_id = (select category_id from retail_outlet_category where retail_outlet_id = $retailOutletId)");
            }
            $sql->where('sbd_distribution.status', '=', 1)
                ->whereNotNull(DB::raw("MONTH(transaction_date)"))
                ->groupby(DB::raw("MONTH(transaction_date)"))
                ->groupby(DB::raw("YEAR(transaction_date)"))
                ->groupby('rpt_sbd_distribution.sku_id')
                ->orderby(DB::raw("MONTH(transaction_date)"));
            $sql = !empty($data) ? $sql->where('sbd_distribution.period_id', '=', $data) : null;

            return $sql->get()->toArray();
        }


        public function getAuditSbdChannelCategoryWise($data, $detail)
        {
            $catalogDetailId = null;
            $period = null;
            $retailOutletId = null;
            $category = null;

            if (!empty($detail['category_id'])) {
                $categoryId = $detail['category_id'];
            }
            if (!empty($detail['period_id'])) {
                $period = $detail['period_id'];
            }
            if (!empty($detail['town_id'])) {
                $town = $detail['town_id'];
            }
            if (!empty($detail['catalog_detail_id'])) {
                $catalogDetailId = $detail['catalog_detail_id'];
            }
//        $start_date = $data[0] . ' 00:00:00';
            //      $end_date = $data[1] . ' 23:59:59';
            $selectListSql = [
                'sbd_distribution.period_id',
                'rpt_sbd_distribution.retail_outlet_id',
                'sbd_distribution.category_id',
                'channel_id',
                DB::raw("count(distinct(rpt_sbd_distribution.sku_id)) as audit_data")
            ];
            $selectListSqlBrand = [
                'sbd_distribution.period_id',
                'rpt_sbd_distribution.retail_outlet_id',
                'catalog_detail_id',
                'sbd_distribution.category_id',
                'channel_id',
                DB::raw("count(distinct(rpt_sbd_distribution.sku_id)) as audit_data")
            ];
            $sql = $this->model->select($selectListSql)
                ->join('retail_outlet', 'retail_outlet.id_retail_outlet', '=', 'rpt_sbd_distribution.retail_outlet_id')
                ->join('retail_outlet_category', 'rpt_sbd_distribution.retail_outlet_id', '=',
                       'retail_outlet_category.retail_outlet_id')
                ->join('category', 'retail_outlet_category.category_id', '=', 'category.id_category')
                ->join('sbd_distribution', function ($q) {
                    $q->on('rpt_sbd_distribution.sbd_distribution_id', '=', 'sbd_distribution.id_sbd_distribution');
                    $q->on('rpt_sbd_distribution.sku_id', '=', 'sbd_distribution.sku_id');
                    $q->where('sbd_distribution.status', '=', 1);
                })
                ->join('catalog_sku', 'rpt_sbd_distribution.sku_id', '=', 'catalog_sku.sku_id');
            if ($catalogDetailId) {
                $sql->select($selectListSqlBrand)->join('catalog_detail', function ($q) use ($catalogDetailId) {
                    $q->on('catalog_sku.catalog_detail_id', '=', 'catalog_detail.id_catalog_detail')
                        ->where('catalog_id', '=', 3);
                    !empty($catalogDetailId) ? $q->where('catalog_detail.id_catalog_detail', '=',
                                                         $catalogDetailId) : null;
                });
                $sql->groupby('catalog_sku.catalog_detail_id')
                    ->groupby('rpt_sbd_distribution.retail_outlet_id')
                    ->groupby('category_id')
                    ->groupby('channel_id')
                    ->orderby('category_id');

            }
            else {
                $sql->groupby('rpt_sbd_distribution.retail_outlet_id')
                    ->groupby('category_id')
                    ->groupby('channel_id')
                    ->orderby('rpt_sbd_distribution.retail_outlet_id');
            }
            !empty($data) ? $sql->whereIn('sbd_distribution.period_id', $data) : null;
//        $sql->where('rpt_sbd_distribution.transaction_date', '>=', $start_date)
//            ->where('rpt_sbd_distribution.transaction_date', '<=', $end_date);
            !empty($categoryId) ? $sql->where('retail_outlet_category.category_id', '=', $categoryId) : null;
            !empty($town) ? $sql->where('retail_outlet.town_id', '=', $town) : null;
            !empty($period) ? $sql->where('sbd_distribution.period_id', '=', $period) : null;
            $result = $sql->get()->toArray();

            return $result;
        }


        public function setSbdReportDistribution($salesOrderId)
        {
            $now = Carbon::now('utc')->toDateString();
            $bu = 1;

            $sbdDistributionList = $this->salesOrderModel->select(
                'sales_order.id_sales_order as sales_order_id',
                'sales_order.sku_id as sku_id',
                'retail_outlet.id_retail_outlet as retail_outlet_id',
                'sbd_distribution.id_sbd_distribution as sbd_distribution_id',
                'sales_order.created_by as created_by',
                'sales_order.updated_by as updated_by',
                'sales_order.created_at as created_at',
                'sales_order.updated_at as updated_at',
                'sales_order.transaction_date as transaction_date',
                'retail_outlet_category.category_id as category_id'
            )->selectRaw('(select ' . $bu . ') as bu_id')
                ->join('retail_outlet', 'retail_outlet.id_retail_outlet', ' = ', 'sales_order.retail_outlet_id')
                ->join('retail_outlet_category', 'retail_outlet_category.retail_outlet_id', ' = ',
                       'retail_outlet.id_retail_outlet')
                ->join('sku', 'sku.id_sku', ' = ', 'sales_order.sku_id')
                ->join('sbd_distribution', function ($join) {

                    $join->on('sbd_distribution.sku_id', ' = ', 'sales_order.sku_id');
                    $join->on('retail_outlet_category.category_id', ' = ', 'sbd_distribution.category_id');

                })
                ->whereIN('id_sales_order', $salesOrderId)
                ->get()->toArray();


            if (count($sbdDistributionList) > 0) {
                $this->model->insert(
                    $sbdDistributionList
                );
            }
        }


        /**
         * @TODO it can be done by a single function with parameter combination.
         * Similar function Multiple times coded.
         *
         * select and where condition should be made dynamic in this condition.
         *
         * get Sales Order History List
         *
         * @param $criteria
         * @param $routeId
         * @param $timePeriod
         *
         * @return
         */

        public function getSBDDistributionList($criteria = null, $routeId, $timePeriod)
        {

            $selection = '*';
            $groupByOption = null;

            if (!is_null($criteria)) {
                $queryRequest = $this->subQueryFetchCriteria($criteria);
                $selection = $queryRequest['selectOption'];
                $groupByOption = $queryRequest['groupByOption'];
            }


            /** Pivot table should be declared */
            $routeRetailOutletPivotTable = "route_retail_outlet";

            $dt = Carbon::now();
            $requiredDate = $this->transformDateTime($dt->subDays($timePeriod * 30));


            /** Pattern as DQL **/
            $query = $this->model
                ->from("$this->rptSbdDistribution as rpt_sbd_distribution")
                ->select($selection)
                ->join("$routeRetailOutletPivotTable as routeRo", "routeRo.retail_outlet_id", '=', 'rpt_sbd_distribution.retail_outlet_id')
                ->join('sales_order', 'sales_order.id_sales_order', '=', 'rpt_sbd_distribution.sales_order_id')
                ->where('routeRo.route_id', '=', $routeId)
                ->where('rpt_sbd_distribution.created_at', '>=', $requiredDate)
                ->filtered()
                ->orderBy('rpt_sbd_distribution.retail_outlet_id');

            if ($groupByOption) {
                $query->groupBy($groupByOption);
            }

            $result = $query->get()->toArray();

            return $result;

        }


        /** It can be handy if is used wisely
         *
         * @param $criteria
         *
         * @return
         */
        private function subQueryFetchCriteria($criteria)
        {

            $subQuerySection = [
                'sbdList' => [
                    'selectOption'  => [DB::raw('sum(quantity) as quantity'), 'rpt_sbd_distribution.sku_id', 'rpt_sbd_distribution.retail_outlet_id', 'rpt_sbd_distribution.bu_id'],
                    //'selectOption' =>  ['no_order.id_no_order as id','no_order.created_at as date','no_order.no_order_reason as status','no_order.retail_outlet_id as outletId'],
                    // 'selectOption' =>['salesOrder.id_sales_order as id','salesOrder.sku_id','salesOrder.created_at as date','salesOrder.quantity','routeRo.retail_outlet_id'],
                    'groupByOption' => ['rpt_sbd_distribution.sku_id']
                ]

            ];

            return $subQuerySection[ $criteria ];

        }

    }