<?php
	/**
	 * Created by PhpStorm.
	 * User: binita
	 * Date: 8/22/16
	 * Time: 3:09 PM
	 */

	namespace Modules\Dashboard\Services;


	use Modules\Dashboard\Repositories\DashboardRepository;
	use Modules\Foundation\Services\AbstractService;
	use Modules\Sales\Repositories\RetailOutletRepository;

	class DashboardService extends AbstractService
	{
		public function __construct(DashboardRepository $repository, RetailOutletRepository $retailOutletRepository)
		{
			$this->repository             = $repository;
			$this->retailOutletRepository = $retailOutletRepository;
		}

		public function getNationalReport()
		{
			return $this->repository->getNationalReport();
		}

		public function getNationalReportRoute()
		{
			return $this->repository->getNationalReportRoute();
		}

		public function getTopFiveDSE()
		{
			return $this->repository->getTopFiveDSE();

		}

		public function getTopFiveDSEByVolume()
		{
			return $this->repository->getTopFiveDSEByVolume();

		}

		public function getOrderReceivedValue()
		{
			/*return $this->repository->getOrderReceivedValue();*/

		}

		public function getOrderInvoiceValue()
		{
			/*return $this->repository->getOrderInvoiceValue();*/

		}

		public function getDetailOfActiveDse($query)
		{
			return $this->repository->getDetailOfActiveDse($query);

		}

		public function getDetailOfScheduledCall($query)
		{
			return $this->repository->getDetailOfScheduledCall($query);

		}

		public function getScheduleRouteRetailOutlet($query)
		{
			return $this->repository->getScheduleRouteRetailOutlet($query);

		}

		public function getDetailOfSuccessFullCall($query)
		{
			return $this->repository->getDetailOfSuccessFullCall($query);

		}

		public function getSuccessfulRouteRetailOutlet($query)
		{
			return $this->repository->getSuccessfulRouteRetailOutlet($query);

		}

		public function getDetailOfUnSuccessFullCall($query)
		{
			return $this->repository->getDetailOfUnSuccessFullCall($query);

		}

		public function getUnSuccessfulRouteRetailOutlet($query)
		{
			return $this->repository->getUnSuccessfulRouteRetailOutlet($query);

		}

		public function getCallNotPerformedRouteRetailOutlet($query)
		{
			return $this->repository->getCallNotPerformedRouteRetailOutlet($query);

		}

//getDetailOfCallMadeRouteRetailOutlet
		public function getDetailOfCallMadeRouteRetailOutlet($query)
		{
			return $this->repository->getDetailOfCallMadeRouteRetailOutlet($query);

		}

		public function getDetailOfCallMade($query)
		{
			return $this->repository->getDetailOfCallMade($query);

		}

		public function getCallNotPerformedDetail($query)
		{
			return $this->repository->getCallNotPerformedDetail($query);

		}


		public function dseProductivityReport($query)
		{
			$data      = null;
			$newArray  = [];
			$todayDate = date('Y-m-d');
			if (!empty($query['start_date'])) {
				$start_date = $query['start_date'];
			}
			if (!empty($query['end_date'])) {
				$end_date = $query['end_date'];
			}

			if ($start_date == $todayDate && $end_date == $todayDate) {

				$data = $this->repository->dseProductivityReport($query);
			}
			else {
				$data = $this->repository->dseProductivityCumulativeReport($query);
			}

			return $data;

		}


		public function getDetailOfActiveDseRouteRetailOutlet($query)
		{
			return $this->repository->getDetailOfActiveDseRouteRetailOutlet($query);
		}

		public function getAllOrderStatusCountWithAmount()
		{
			return $this->repository->getAllOrderStatusCountWithAmount();

		}

		public function getTodayOrderStatusCountWithAmount()
		{
			return $this->repository->getTodayOrderStatusCountWithAmount();

		}

		public function getNationalReportMonthly()
		{
			return $this->repository->getNationalReportMonthly();

		}

		public function getNationalReportRouteMonthly()
		{
			return $this->repository->getNationalReportRouteMonthly();

		}

		public function getAllOrderStatusCountWithAmountMonthly()
		{
			return $this->repository->getAllOrderStatusCountWithAmountMonthly();

		}


		public function getSummaryReport($query)
		{
			$data      = null;
			$newArray  = [];
			$todayDate = date('Y-m-d');
			if (!empty($query['filter']['start_date'])) {
				$start_date = $query['filter']['start_date'];
			}
			if (!empty($query['filter']['end_date'])) {
				$end_date = $query['filter']['end_date'];
			}

			if ($start_date == $todayDate && $end_date == $todayDate) {

				$data = $this->repository->getSummaryReport($query);
			}// elseif ($start_date != $todayDate && $end_date != $todayDate) {
			else {
				$data = $this->repository->getSummaryReportAggregate($query);
			}
//        else {
//
//            $todayData = $this->repository->getSummaryReport($query);
//           // dump($todayData);
//            $tillDate = $this->repository->getSummaryReportAggregate($query);
//            //dump($tillDate);
//            $data = array_merge($todayData, $tillDate);
//
////         dump($data);
////            foreach($data as $key=>$value){
////                $newArray[$value->town_id][$value->distributor_id]['total_order_value'] = $value->total_order_value;
////            }
//        }

//dump($newArray);
			return $data;
		}


		public function getOfflineCall()
		{
			return $this->repository->getOfflineCall();
		}

		public function getDetailOfflineRouteRetailOutlet($query)
		{
			return $this->repository->getDetailOfflineRouteRetailOutlet($query);

		}

		public function getChannelCategoryWiseReport($query)
		{
			$data      = null;
			$flag      = false;
			$todayDate = date('Y-m-d');

			if (isset($query['limit'])) {
				$data['limit'] = $query['limit'];

			}

			if (!empty($query['start_date'])) {
				$start_date    = $query['start_date'];
				$data['start'] = $start_date;
			}

			if (!empty($query['end_date'])) {
				$end_date    = $query['end_date'];
				$data['end'] = $end_date;
			}

			if ($start_date == $todayDate && $end_date == $todayDate) {
				$flag = true;
			}

			return $this->repository->getChannelCategoryWiseReport($data, $flag);

		}

		/**
		 *
		 * Get the report data with the filter inputs
		 * $request consists of all the requests.
		 *
		 * @param $request
		 *
		 * @return string
		 */
		public function getReports($request)
		{
			if ($request['dashboard'] == 'activeDse') {
				$rpt = $this->getDetailOfActiveDseRouteRetailOutlet($request);
			}
			elseif ($request['dashboard'] == 'unsuccess') {
				$rpt = $this->getUnSuccessfulRouteRetailOutlet($request);
			}
			elseif ($request['dashboard'] == 'scheduled') {
				$rpt = $this->getScheduleRouteRetailOutlet($request);
			}
			elseif ($request['dashboard'] == 'success') {
				$rpt = $this->getSuccessfulRouteRetailOutlet($request);
			}
			elseif ($request['dashboard'] == 'callMade') {
				$rpt = $this->getDetailOfCallMadeRouteRetailOutlet($request);
			}
			elseif ($request['dashboard'] == 'callNotPerformed') {
				$rpt = $this->getCallNotPerformedDetail($request);
			}
			elseif ($request['dashboard'] == 'dseProductivity') {
				$rpt = $this->dseProductivityReport($request);
			}
			elseif ($request['dashboard'] == 'coverage') {
				$rpt = $this->retailOutletRepository->getActiveInactiveR0($request);
			}
			elseif ($request['dashboard'] == 'channel-category') {
				$rpt = $this->getChannelCategoryWiseReport($request);
			}

//        if ($request['dashboard'] == 'activeDse') {
//            $rpt = $this->getDetailOfActiveDseRouteRetailOutlet($request);
//        } else {
//            if ($request['dashboard'] == 'unsuccess') {
//                $rpt = $this->getUnSuccessfulRouteRetailOutlet($request);
//            } else {
//                if ($request['dashboard'] == 'scheduled') {
//                    $rpt = $this->getScheduleRouteRetailOutlet($request);
//                } else {
//                    if ($request['dashboard'] == 'success') {
//                        $rpt = $this->getSuccessfulRouteRetailOutlet($request);
//                    } else {
//                        if ($request['dashboard'] == 'callMade') {
//                            $rpt = $this->getDetailOfCallMadeRouteRetailOutlet($request);
//                        } else {
//                            if ($request['dashboard'] == 'callNotPerformed') {
//                                $rpt = $this->getCallNotPerformedDetail($request);
//                            } else {
//                                if ($request['dashboard'] == 'dseProductivity') {
//                                    $rpt = $this->dseProductivityReport($request);
//                                } else {
//                                    if ($request['dashboard'] == 'coverage') {
//                                        $rpt = $this->retailOutletRepository->getActiveInactiveR0($request);
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }
			return $rpt;
		}

	}