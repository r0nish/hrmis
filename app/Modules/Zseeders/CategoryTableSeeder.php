<?php

	namespace Modules\Zseeders;

	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\DB;
	use Faker;

	class CategoryTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 */
		public function run()
		{
			//
		}

		public static function seedCategory()
		{
			$faker = new Faker\Factory();
			$faker = $faker->create();

			DB::table('channel')->insert([
											 'title'  => $faker->title,
											 'status' => '1',
										 ]);
		}

		public static function cleanSeeding()
		{
			DB::statement('SET FOREIGN_KEY_CHECKS=0');

			DB::table('channel')->truncate();
			DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
