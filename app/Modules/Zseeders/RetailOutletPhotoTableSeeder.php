<?php

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Faker;

    class RetailOutletPhotoTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run()
        {
            //
        }

        public static function retailOutletSeed()
        {
            $faker = new Faker\Factory(); //::create();
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
        }

        public static function cleanDatabase()
        {
            $tables = ['route', 'route_visit_type', 'route_visit_frequency', 'route_visit_category',
                'route_delivery_type', 'retail_outlet',];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
