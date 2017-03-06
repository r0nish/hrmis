<?php


	namespace Modules\Security\Repositories;

	use Modules\Foundation\Repositories\AbstractRepository;
	use Modules\Security\Entities\MenuPermissionInterface;

	class MenuPermissionRepository extends AbstractRepository implements MenuPermissionRepositoryInterface
	{
		protected $model;

		public function __construct(MenuPermissionInterface $model)
		{
			$this->model = $model;
		}
	}
