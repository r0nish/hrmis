<?php

	namespace App\Modules\Foundation\Repositories;

	/**
	 * Interface to enforce all the repository interface
	 */
	interface BaseRepositoryInterface
	{

		/**
		 * Get all.
		 *
		 */
		public function get();

		/**
		 * Get specific data by Id
		 *
		 * @param $id
		 */
		public function getById($id);

		/**
		 * Create specific data
		 *
		 * @param array $data
		 *
		 * @return mixed
		 * @internal param $id
		 */
		public function create(array $data = []);

		/**
		 * Update specific data
		 *
		 * @param       $id
		 * @param array $data
		 *
		 * @return mixed
		 * @internal param BaseModel $model
		 */
		public function update($id, array $data = []);

		/**
		 * Delete specific data
		 *
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function delete($id);

		/**
		 * Deactivate specific data
		 *
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function deActivate($id);

		/**
		 * Deactivate specific data
		 *
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function activate($id);


	}

