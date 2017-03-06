<?php

	namespace Modules\Security\Repositories;

	use Modules\Foundation\Repositories\BaseRepositoryInterface;

	interface MenuRepositoryInterface extends BaseRepositoryInterface
	{

		public function generateMenu($roleId, $showAll, $isVisible);

		public function getParentPermissionByMenuID($menuId);

		public function permission($menuId, $menu);

		public function getMenuPermission($roleId, $menuId);

		public function getMenuChildren($menuId);

		public function getMenuPermissionSettings($menuId);

		public function getMenuEntitiesPermissionSettings($menuId);
	}
