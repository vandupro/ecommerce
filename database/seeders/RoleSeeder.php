<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        for($i=4; $i<20;$i++){
            DB::table('roles')->insert([
                "name"=>$faker->name,
                "desc"=>$faker->text(10),
            
                // "register_at"=>"register_at",

            ]);
    
        }
    }
}
