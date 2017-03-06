<?php

	namespace Modules\Zseeders;

	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\DB;
	use Faker;

	class PeriodTableSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 */
		public function run()
		{
			//
		}

		public static function setUpThis()
		{
			$faker = new Faker\Factory();
			$faker = $faker->create();

			/*
			DB::table('sku')->insert([
				'title' => $faker->title,
				'GTIN' => $faker->buildingNumber,
				'EAN' => $faker->countryCode,
				'tag' => $faker->randomNumber(2),
				'PSKU' => '0',
				'SU' => '0.00',
				'business_unit_id' => '1',
			]);
			*/

		}
		/*
		public static function cleanDatabase()
		{
			////$tables = array('retail_outlet', 'sku', 'sales_order');
	
			DB::statement('SET FOREIGN_KEY_CHECKS=0');
			foreach ($tables as $table) {
				DB::table($table)->truncate();
			}
			DB::statement('SET FOREIGN_KEY_CHECKS=1');
		}
		*/
	}
