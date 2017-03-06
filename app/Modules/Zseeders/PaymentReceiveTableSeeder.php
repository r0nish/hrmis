<?php
    /**
     * Created by PhpStorm.
     * User: BNTA
     * Date: 1/31/2016
     * Time: 12:51 PM
     */

    namespace Modules\Zseeders;

    use Illuminate\Support\Facades\DB;
    use Faker;
    use Illuminate\Database\Seeder;


    class PaymentReceiveTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run()
        {
            //
        }

        public static function seedPaymentReceive()
        {
            $faker = new Faker\Factory();
            $faker = $faker->create();

            DB::table('channel')->insert([
                                             'title'  => $faker->title,
                                             'status' => '1',
                                         ]);

            DB::table('category')->insert([
                                              'title'      => $faker->title,
                                              'status'     => '1',
                                              'channel_id' => '1',
                                          ]);

            DB::table('geographic_lookup')->insert([
                                                       'title'                       => $faker->title,
                                                       'parent_geographic_lookup_id' => '1',
                                                       'status'                      => '1',
                                                   ]);

            DB::table('geographic_location')->insert([
                                                         'geographic_lookup_id' => '1',
                                                         'title'                => $faker->title,
                                                         'parent_id'            => '1',
                                                         'status'               => '1',
                                                     ]);

            DB::table('town')->insert([
                                          'title'                  => $faker->title,
                                          'geographic_location_id' => '1',
                                          // 'boundary' => str_random(50),
                                          'status'                 => '1',
                                      ]);

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
            DB::table('business_unit')->insert([
                                                   'title'  => $faker->title,
                                                   'status' => '1',
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
            $tables = ['order_status', 'channel', 'category', 'geographic_lookup', 'geographic_location', 'town',
                'retail_outlet', 'business_unit', 'sku', 'sales_order'];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }


    }
