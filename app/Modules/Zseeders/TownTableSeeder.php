<?php

    namespace Modules\Zseeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class TownTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run()
        {
            //
        }

        public static function seedTown()
        {
            $faker = new \Faker\Factory();
            $faker = $faker->create();

            DB::table('geographic_lookup')->insert([
                                                       //'id_geographic_lookup' => '1',
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
        }

        public static function cleanDatabase()
        {
            $tables = ['geographic_lookup', 'geographic_location'];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
