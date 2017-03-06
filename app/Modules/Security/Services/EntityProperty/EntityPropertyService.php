<?php

	namespace Modules\Security\Services\EntityProperty;

	use Modules\Foundation\Services\AbstractService;
	use Modules\Security\Repositories\EntityPropertyRepositoryInterface;
	use Modules\Security\Validators\EntityPropertyValidator;

	class EntityPropertyService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(EntityPropertyRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new EntityPropertyValidator();
		}

		/** call to repository permission
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function editEntityPermission($entityPropertyId, $entityPermission)
		{

			return $this->repository->editEntityPermission($entityPropertyId, $entityPermission);
		}

		/** call repository entities permission
		 *
		 * @param $entityPropertyId
		 *
		 * @return mixed
		 */
		function getEntitiesPermissionSettings($entityPropertyId)
		{
			return $this->repository->getEntitiesPermissionSettings($entityPropertyId);
		}

		/**
		 * call repository entities settings
		 *
		 * @param $menuId
		 *
		 * @return mixed
		 */
		public function getEntitiesSettings($menuId)
		{
			return $this->repository->getEntitiesSettings($menuId);
		}


		public function getEntityPropertyPermissionByRoleIdAndEntityId($roleId, $entityId)
		{
			return $this->repository->getEntityPropertyPermissionByRoleIdAndEntityId($roleId, $entityId);

		}
	}
