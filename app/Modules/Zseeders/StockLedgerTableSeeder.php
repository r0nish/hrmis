<?php

    namespace Modules\Zseeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Faker;

    class StockLedgerTableSeeder extends Seeder
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

            DB::table('distributor')->insert([
                                                 'title'       => $faker->title,
                                                 'description' => $faker->paragraph(2),
                                                 'status'      => '1',
                                             ]);
            DB::table('sku')->insert([
                                         'title'            => $faker->title,
                                         'GTIN'             => $faker->buildingNumber,
                                         'EAN'              => $faker->countryCode,
                                         'tag'              => $faker->postcode,
                                         'PSKU'             => '0',
                                         'SU'               => '0.00',
                                         'business_unit_id' => '1',
                                     ]);

        }

        public static function cleanDatabase()
        {
            $tables = ['distributor', 'sku'];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

    }
