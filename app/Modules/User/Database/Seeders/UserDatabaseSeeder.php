<?php

	namespace Modules\User\Database\Seeders;

	use Illuminate\Database\Seeder;
	use Illuminate\Database\Eloquent\Model;

	class UserDatabaseSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 */
		public function run()
		{
			Model::unguard();

			factory('Modules\User\Entities\User', 5)->create();

			// $this->call("UserTableSeeder");
		}
	}
