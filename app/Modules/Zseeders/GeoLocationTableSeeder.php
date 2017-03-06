<?php

	namespace Modules\Zseeders;

	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\DB;
	use Faker;

	class GeoLocationTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 */
		public function run()
		{
			//
		}

		public static function setupGeoLocation()
		{
			$faker = new Faker\Factory(); //::create();
			$faker = $faker->create();
			DB::table('geographic_lookup')->insert([
													   'title'  => $faker->title,
													   'status' => '1',
												   ]);
		}

		public static function cleanDatabase()
		{
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			DB::table('geographic_lookup')->delete();
			DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
	}
