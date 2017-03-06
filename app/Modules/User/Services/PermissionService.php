<?php

	namespace App\Modules\User\Services;

	use App\Modules\User\Repositories\PermissionRepositoryInterface;
	use App\Modules\Foundation\Services\AbstractService;
	use App\Modules\User\Validators\PermissionValidator;

	class PermissionService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(PermissionRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new PermissionValidator();
		}
	}
