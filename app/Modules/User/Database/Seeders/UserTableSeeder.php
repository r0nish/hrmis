<?php

	namespace Modules\User\Database\Seeders;

	use Illuminate\Database\Seeder;
	use Illuminate\Database\Eloquent\Model;

	class UserTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 */
		public function run()
		{
			Model::unguard();
			factory('User', 5)->create();
			// $this->call("OthersTableSeeder");
		}
	}
