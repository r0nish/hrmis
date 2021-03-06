<?php

    namespace Modules\Zseeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Faker;

    class RetailOutletTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run()
        {
            //
        }

        public static function setUpRetailOutlet()
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
                                          // 'boundary' => $faker->randomDigitNotNull,
                                          'status'                 => '1',
                                      ]);
        }

        public static function cleanDatabase()
        {
            $tables = ['channel', 'category', 'geographic_lookup', 'geographic_location', 'town'];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
