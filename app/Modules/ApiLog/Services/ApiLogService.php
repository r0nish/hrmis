<?php
	namespace Modules\ApiLog\Services;

	use Modules\ApiLog\Repositories\ApiLogRepositoryInterface;
	use Modules\Foundation\Services\AbstractService;

	class ApiLogService extends AbstractService
	{
		protected $validator;
		protected $repository;

		public function __construct(ApiLogRepositoryInterface $repositoryInterface)
		{
			$this->repository = $repositoryInterface;
		}

		/**
		 * Pre store Request headers
		 *
		 * @param $requestString
		 * @param $resultResponse
		 *
		 * @return mixed
		 * @internal param $syncdata
		 */
		public function storeLogAOP($requestString, $resultResponse)
		{

			$syncData = json_encode($requestString[0]);

			$array = [
				'request_headers' => '',
				'request'         => $syncData,
				'response'        => json_encode($resultResponse),
				'title'           => 'SyncOrders',
				'checksum_value'  => $requestString[1]
			];

			$response = $this->repository->create($array);

			return $response;
		}

	}
