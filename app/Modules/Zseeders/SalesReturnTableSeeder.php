<?php

    namespace Modules\Zseeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Faker;

    class SalesReturnTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run()
        {
            //
        }

        public static function setUpSalesReturn()
        {
            $faker = new Faker\Factory();
            $faker = $faker->create();

            DB::table('retail_outlet')->insert([
                                                   'title'                 => $faker->title,
                                                   'contact_number1'       => $faker->phoneNumber,
                                                   'contact_number2'       => $faker->phoneNumber,
                                                   'contact_name'          => $faker->phoneNumber,
                                                   'geolocation_longitude' => str_random(10),
                                                   'geolocation_latitude'  => str_random(10),
                                                   'channel_id'            => '1',
                                                   'category_id'           => '1',
                                                   'town_id'               => '1',
                                                   'PAN_number'            => str_random(10),
                                                   'status'                => '1',
                                               ]);

            DB::table('sku')->insert([
                                         'title'            => $faker->title,
                                         'GTIN'             => $faker->buildingNumber,
                                         'EAN'              => $faker->countryCode,
                                         'tag'              => $faker->randomNumber(2),
                                         'PSKU'             => '0',
                                         'SU'               => '0.00',
                                         'business_unit_id' => '1',
                                     ]);
            DB::table('sales_order')->insert([
                                                 'retail_outlet_id'      => $faker->title,
                                                 'GID'                   => '1',
                                                 'sku_id'                => 1,
                                                 'quantity'              => $faker->randomNumber(2),
                                                 'price'                 => $faker->randomNumber(5),
                                                 'promotion_id'          => 1,
                                                 'order_status_id'       => 1,
                                                 'geolocation_latitude'  => '40.99',
                                                 'geolocation_longitude' => '50.00',

                                             ]);
        }

        public static function cleanDatabase()
        {
            $tables = ['retail_outlet', 'sku', 'sales_order'];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
