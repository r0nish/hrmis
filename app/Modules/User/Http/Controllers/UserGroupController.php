<?php

	namespace App\Modules\User\Http\Controllers;


	use App\Modules\Foundation\Controllers\AbstractController;
	use App\APIHelpers\Transformers\UserGroupTransformer;
	use Illuminate\Http\Request;
	use App\Http\Requests;
	use Illuminate\Support\MessageBag;
	use App\Modules\User\Entities\UserGroup;
	use App\Modules\User\Services\UserGroupService;

	class UserGroupController extends AbstractController
	{

		protected $service;
		protected $dataTransformer;
		protected $primary_key = "id_user_group";

		/**
		 * UserGroupController constructor.
		 *
		 * @param UserGroupService     $service
		 * @param UserGroupTransformer $userGroupTransformer
		 */
		public function __construct(UserGroupService $service, UserGroupTransformer $userGroupTransformer)
		{
			$this->service = $service;
			$this->dataTransformer = $userGroupTransformer;

		}

		/**
		 * Default
		 * @return mixed
		 *
		 */
		public function index()
		{

			$permission = [];
			$userGroup = $this->service->getPaginate();

			return $this->respond([
									  'total' => $userGroup['total'],
									  'data'  => $this->dataTransformer->transformCollection($userGroup['data'], $permission)
								  ]);
		}

		/** get user group to assign the territory  */

		public function getUserGroupToAssignTerritory()
		{
			$permission = [];
			$userGroup = $this->service->select('geo_status', '1');

			return $this->respond([
									  'data' => $this->dataTransformer->transformCollection($userGroup, $permission)
								  ]);
		}


	}
