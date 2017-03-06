<?php

	namespace Modules\Zseeders;

	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\DB;
	use Faker;

	class UserTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 */
		public function run()
		{
			//
		}

		public static function seedUser()
		{
			$faker = new Faker\Factory();
			$faker = $faker->create();

			DB::table('user_group')->insert([
												'group_name' => $faker->userName,
												'status'     => '1',
											]);
		}

		public static function cleanSeeding()
		{
			DB::statement('SET FOREIGN_KEY_CHECKS=0');

			DB::table('channel')->user_group();
			DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
