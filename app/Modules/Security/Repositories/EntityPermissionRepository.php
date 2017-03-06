<?php


	namespace Modules\Security\Repositories;

	use Modules\Foundation\Repositories\AbstractRepository;
	use Modules\Security\Entities\EntityPermissionInterface;

	class EntityPermissionRepository extends AbstractRepository implements EntityPermissionRepositoryInterface
	{
		protected $model;

		public function __construct(EntityPermissionInterface $model)
		{
			$this->model = $model;
		}


	}
