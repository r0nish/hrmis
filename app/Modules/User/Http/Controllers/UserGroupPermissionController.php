<?php

	namespace App\Modules\User\Http\Controllers;

	use App\APIHelpers\Transformers\UserGroupPermissionTransformer;
	use App\Modules\Foundation\Controllers\AbstractController;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\App;
	use App\Modules\User\Entities\UserGroupPermission;
	use App\Modules\User\Services\UserGroupPermissionService;

	class UserGroupPermissionController extends AbstractController
	{

		protected $service;

		protected $dataTransformer;

		protected $primary_key = 'id_user_group_permission';

		/**
		 * UserGroupPermissionController constructor.
		 *
		 * @param UserGroupPermissionService     $service
		 * @param UserGroupPermissionTransformer $userGroupPermissionTransformer
		 */
		public function __construct(UserGroupPermissionService $service, UserGroupPermissionTransformer $userGroupPermissionTransformer)
		{
			$this->service = $service;
			$this->dataTransformer = $userGroupPermissionTransformer;

		}

	}
