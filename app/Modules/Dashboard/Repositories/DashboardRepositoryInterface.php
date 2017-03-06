<?php
	/**
	 * Created by PhpStorm.
	 * User: binita
	 * Date: 9/9/16
	 * Time: 11:43 AM
	 */

	namespace Modules\Dashboard\Repositories;

	use Modules\Foundation\Repositories\BaseRepositoryInterface;


	interface DashboardRepositoryInterface extends BaseRepositoryInterface
	{
		public function getNationalReport();

		public function getNationalReportRoute();


		public function getTopFiveDSE();


		public function getTopFiveDSEByVolume();


		// public function getOrderReceivedValue();


		public function getOrderInvoiceValue();


		public function getDetailOfActiveDse($query);


		public function getDetailOfScheduledCall($query);


		public function getDetailOfSuccessFullCall($query = null);


		public function getDetailOfUnSuccessFullCall($query = null);


		public function getDetailOfCallMade($query);


		public function getCallNotPerformedDetail($query);


	}