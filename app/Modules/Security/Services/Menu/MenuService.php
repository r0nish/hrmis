<?php

	namespace Modules\Security\Services\Menu;

	use Modules\Security\Repositories\MenuRepositoryInterface;
	use Modules\Foundation\Services\AbstractService;
	use Modules\Security\Validators\MenuValidator;

	class MenuService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(MenuRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new MenuValidator();
		}

		/** call to repository generate menu
		 *
		 * @param $roleId
		 * @param $showAll
		 *
		 * @return mixed
		 */
		public function getGenerateMenu($roleId, $showAll, $isVisible)
		{

			return $this->repository->generateMenu($roleId, $showAll, $isVisible);
		}

		/** call to repository permission
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function permission($menuId, $menu)
		{

			return $this->repository->permission($menuId, $menu);
		}

		/** call to parent permission by Menu Id
		 *
		 * @param $menuId
		 *
		 * @return mixed
		 */
		public function getParentPermissionByMenuID($menuId)
		{
			return $this->repository->getParentPermissionByMenuID($menuId);
		}

		/** call to parent permission by role Id
		 *
		 * @param $roleId
		 *
		 * @return mixed
		 */
		public function getMenuPermission($roleId = 0, $menuId = 0)
		{
			return $this->repository->getMenuPermission($roleId, $menuId);
		}

		/** fetch menu children
		 *
		 * @param $roleId
		 *
		 * @return mixed
		 */
		public function getMenuChildren($menuId)
		{
			return $this->repository->getMenuChildren($menuId);
		}

		/** menu permission setting
		 *
		 * @param $menuId
		 *
		 * @return mixed
		 */
		public function getMenuPermissionSettings($menuId)
		{
			return $this->repository->getMenuPermissionSettings($menuId);
		}

		/** Menu Entities permission setting
		 *
		 * @param $menuId
		 *
		 * @return mixed
		 */
		public function getMenuEntitiesPermissionSettings($menuId)
		{
			return $this->repository->getMenuEntitiesPermissionSettings($menuId);
		}


		public function getAllPermissions($roleId)
		{
			return $this->repository->getAllPermissions($roleId);
		}


		public function getChildMenu()
		{
			return $this->repository->getChildMenu();
		}

	}
