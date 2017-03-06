<?php
    /**
     * Created by PhpStorm.
     * User: BNTA
     * Date: 1/31/2016
     * Time: 12:40 AM.
     */

    namespace Modules\Zseeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Faker;

    class PackagingSeederTable extends Seeder
    {
        public function run()
        {
            //
        }

        public static function seedPackaging()
        {
            $faker = new Faker\Factory();
            $faker = $faker->create();

            DB::table('unit')->insert([
                                          'title' => $faker->title,
                                      ]);

            DB::table('business_unit')->insert([
                                                   'title'  => $faker->title,
                                                   'status' => '1',
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
            $tables = ['unit', 'business_unit', 'sku'];

            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
