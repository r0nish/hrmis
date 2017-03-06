<?php

	namespace Modules\Security\Repositories;

	use Modules\Foundation\Repositories\BaseRepositoryInterface;

	interface EntityPropertyRepositoryInterface extends BaseRepositoryInterface
	{

		public function editEntityPermission($entityPropertyId, $entityPermission);

		public function getEntitiesPermissionSettings($entityPropertyId);

		public function getEntitiesSettings($menuId);
	}
