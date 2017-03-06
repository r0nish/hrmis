<?php

	namespace Modules\Security\Services\MenuPermission;

	use Modules\Security\Repositories\MenuPermissionRepositoryInterface;
	use Modules\Foundation\Services\AbstractService;
	use Modules\Security\Validators\MenuPermissionValidator;

	class MenuPermissionService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(MenuPermissionRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new MenuPermissionValidator();
		}

	}
