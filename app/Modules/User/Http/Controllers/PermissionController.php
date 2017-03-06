<?php

	namespace App\Modules\User\Http\Controllers;

	use App\APIHelpers\Transformers\PermissionTransformer;
	use App\Modules\Foundation\Controllers\AbstractController;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\App;
	use Modules\User\Entities\Permission;
	use App\Modules\User\Services\PermissionService;

	class PermissionController extends AbstractController
	{

		protected $service;

		protected $dataTransformer;

		/**
		 * PermissionController constructor.
		 *
		 * @param PermissionService     $service
		 * @param PermissionTransformer $permissionTransformer
		 */
		public function __construct(PermissionService $service, PermissionTransformer $permissionTransformer)
		{
			$this->service = $service;
			$this->dataTransformer = $permissionTransformer;

		}

	}
