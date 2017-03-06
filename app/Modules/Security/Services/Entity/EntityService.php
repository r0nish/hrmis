<?php

	namespace Modules\Security\Services\Entity;

	use Modules\Foundation\Services\AbstractService;
	use Modules\Security\Repositories\EntityRepositoryInterface;
	use Modules\Security\Validators\EntityValidator;

	class EntityService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(EntityRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new EntityValidator();
		}

		public function getEntities()
		{
			return $this->repository->getEntities();
		}

		public function getEntityWithProperties($menuId)
		{
			return $this->repository->getEntityWithProperties($menuId);

		}
	}
