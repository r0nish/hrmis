<?php

    namespace Modules\Zseeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Faker;

    class RouteScheduleSeederTable extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run()
        {
            //
        }

        public static function routeScheduleSeed()
        {
            $faker = new Faker\Factory(); //::create();
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
                                          //  'boundary' => $faker->randomDigitNotNull,
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

            DB::table('route_delivery_type')->insert([
                                                         'title' => $faker->title,

                                                     ]);

            DB::table('route_visit_category')->insert([
                                                          'title' => $faker->title,
                                                      ]);
            DB::table('route_visit_frequency')->insert([
                                                           'title'     => $faker->title,
                                                           'frequency' => '1',
                                                           'startdate' => $faker->date('Y-m-d'),
                                                           'status'    => '1',
                                                       ]);
            DB::table('route_visit_type')->insert([
                                                      'title' => $faker->title,
                                                  ]);
            DB::table('route')->insert([
                                           'route_visit_category_id'  => '1',
                                           'route_visit_type_id'      => '1',
                                           'route_delivery_type_id'   => '1',
                                           'route_visit_frequency_id' => '1',
                                       ]);
        }

        public static function cleanDatabase()
        {
            $tables = ['channel', 'category', 'geographic_lookup', 'geographic_location', 'town', 'route', 'route_visit_type', 'route_visit_frequency', 'route_visit_category',
                'route_delivery_type', 'retail_outlet',];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
