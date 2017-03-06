<?php


	namespace App\Modules\User\Repositories;

	use App\Modules\User\Entities\UserGroupPermissionInterface;
	use App\Modules\Foundation\Repositories\AbstractRepository;

	class UserGroupPermissionRepository extends AbstractRepository implements UserGroupPermissionRepositoryInterface
	{
		protected $model;

		public function __construct(UserGroupPermissionInterface $model)
		{
			$this->model = $model;
		}
	}
