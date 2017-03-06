<?php


	namespace App\Modules\User\Repositories;

	use App\Modules\User\Entities\PermissionInterface;
	use App\Modules\Foundation\Repositories\AbstractRepository;

	class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
	{
		protected $model;

		public function __construct(PermissionInterface $model)
		{
			$this->model = $model;
		}
	}
