<?php

	namespace App\Modules\User\Services;

	use App\Modules\User\Repositories\UserGroupRepositoryInterface;
	use App\Modules\Foundation\Services\AbstractService;
	use App\Modules\User\Validators\UserGroupValidator;

	class UserGroupService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(UserGroupRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new UserGroupValidator();
		}
	}
