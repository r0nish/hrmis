<?php

	namespace App\Modules\Foundation\Services;

	abstract class AbstractService
	{
		/**
		 * The Repository instance.
		 *
		 * @var BuRepositoryInterface
		 */
		protected $repository;
		protected $validator;


		// TODO Construction Identification. Or Interface Implementations.
		/*    /**
			 * @param AbstractRepository $repository
			 */
		/*public function __construct(BaseRepositoryInterface $repository)
		{
			$this->repository = $repository;
		}*/

		/**
		 * Create a Bu.
		 *
		 * @param array $buData
		 *
		 * @return new Bu id if success else false
		 */
		public function create($buData = [])
		{

			if (isset($this->validator) && $this->validator->with($buData) && !$this->validator->passes()) {
				return $this->validator->errors();
			}

			return $this->repository->create($buData);
		}

		/**
		 * Edit Bu.
		 *
		 * @param array $buData
		 *
		 * @return Bu id if success else false
		 */
		public function update($id, $buData = [])
		{
			if ($this->validator->with($buData) && !$this->validator->passes()) {
				return $this->validator->errors();
			}

			return $this->repository->update($id, $buData);
		}

		/**
		 * Delete Bu.
		 *
		 * @param array /int $ids
		 *
		 * @return true if success else false
		 */
		public function delete($ids)
		{
			return $this->repository->delete($ids);
		}

		/**
		 * Deactivate Bu.
		 *
		 * @param array /int $ids
		 *
		 * @return no of ids if success else 0
		 */
		public function deactivate($ids)
		{
			return $this->repository->deActivate($ids);
		}

		/**
		 * Deactivate Bu.
		 *
		 * @param array /int $ids
		 *
		 * @return no of ids if success else 0
		 */
		public function activate($ids)
		{
			return $this->repository->activate($ids);
		}

		/**
		 * select Bu.
		 *
		 * @param string $field
		 * @param string $value
		 *
		 * @return array if success else false
		 */
		public function select($field, $value = null)
		{
			return $this->repository->select($field, $value);
		}

		/**
		 * @return mixed
		 */
		public function getAll()
		{
			return $this->repository->getAll();
		}


		/**
		 * Get the data with pagination.
		 *
		 * @return mixed
		 *
		 */

		public function getPaginateList($query)
		{

			return $this->repository->getPaginateList($query);
		}


		/** get All the list with hierarchy mostly unused. */

		public function getAllList()
		{
			return $this->repository->getAllList();
		}

		/**
		 * Get the data with pagination.
		 *
		 * @return mixed
		 *
		 */

		public function getPaginate()
		{
			return $this->repository->getPaginate();
		}

		/**
		 * @param $id
		 *
		 * @return mixed
		 */
		public function getById($id)
		{
			return $this->repository->getById($id);
		}


	}
