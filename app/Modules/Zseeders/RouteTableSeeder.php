<?php

    namespace Modules\Zseeders;

    use Illuminate\Support\Facades\DB;
    use Illuminate\Database\Seeder;
    use Faker;

    class RouteTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run()
        {
            //
        }

        public static function setUpRouteSeed()
        {
            $faker = new Faker\Factory(); //::create();
            $faker = $faker->create();

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
        }

        public static function cleanDatabase()
        {
            $tables = ['route_delivery_type', 'route_visit_category', 'route_visit_frequency', 'route_visit_type'];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->delete();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
