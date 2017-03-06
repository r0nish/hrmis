<?php

	namespace App\Modules\User\Services;

	use App\Modules\User\Repositories\UserGroupPermissionRepositoryInterface;
	use App\Modules\Foundation\Services\AbstractService;
	use App\Modules\User\Validators\UserGroupPermissionValidator;

	class UserGroupPermissionService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(UserGroupPermissionRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new UserGroupPermissionValidator();
		}
	}
