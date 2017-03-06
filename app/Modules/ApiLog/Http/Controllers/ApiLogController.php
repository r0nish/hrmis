<?php
	/**
	 * Created by PhpStorm.
	 * User: udnbikesh
	 * Date: 10/21/16
	 * Time: 10:11 AM
	 */

	namespace Modules\ApiLog\Http\Controllers;

	use Modules\ApiLog\Services\ApiLogService;
	use Modules\ApiLog\Transformers\ApiLogTransformer;
	use Modules\Foundation\Controllers\AbstractController;


	class ApiLogController extends AbstractController
	{

		protected $service;

		protected $dataTransformer;

		protected $primary_key = 'id_api_log';

		/**
		 * AdjustmentController constructor.
		 *
		 * @param ApiLogService                                      $service
		 * @param \Modules\ApiLog\Http\Controllers\ApiLogTransformer $apiLogTransformer
		 *
		 * @internal param AdjustmentTransformer $adjustmentTransformer
		 */
		public function __construct(ApiLogService $service, ApiLogTransformer $apiLogTransformer)
		{
			$this->service = $service;
			$this->dataTransformer = $apiLogTransformer;
		}

	}