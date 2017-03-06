<?php

	namespace Modules\ApiLog\Entities;

	use Modules\Foundation\Entities\BaseModel;

	class ApiLog extends BaseModel implements ApiLogInterface
	{

		/**
		 * Api Log
		 *
		 * id_api_log` int(10) UNSIGNED NOT NULL,
		 * `request_headers` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 * `request` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 * `response` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 * `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 * `checksum_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 * `created_by` int(10) UNSIGNED DEFAULT NULL,
		 * `updated_by` int(10) UNSIGNED DEFAULT NULL,
		 * `created_at` timestamp NULL DEFAULT NULL,
		 * `updated_at` timestamp NULL DEFAULT NULL
		 */


		/**
		 * table name.
		 */
		protected $table = 'api_log';

		protected $guarded = [];

		protected $primaryKey = 'id_api_log';


		/**
		 * Get all.
		 *
		 */
		public function get()
		{
			// TODO: Implement get() method.
		}

		/**
		 * Get specific data by Id
		 *
		 * @param $id
		 */
		public function getById($id)
		{
			// TODO: Implement getById() method.
		}

		/**
		 * Deactivate specific data
		 *
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function deActivate($id)
		{
			// TODO: Implement deActivate() method.
		}

		/**
		 * Deactivate specific data
		 *
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function activate($id)
		{
			// TODO: Implement activate() method.
		}
	}
