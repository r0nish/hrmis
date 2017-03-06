<?php

	namespace Modules\Security\Services\EntityPermission;

	use Modules\Security\Repositories\EntityPermissionRepositoryInterface;
	use Modules\Foundation\Services\AbstractService;
	use Modules\Security\Validators\EntityPermissionValidator;

	class EntityPermissionService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(EntityPermissionRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new EntityPermissionValidator();
		}


	}
