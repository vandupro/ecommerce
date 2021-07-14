<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;
class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        for($i=1; $i<=20;$i++){
            DB::table('roles_users')->insert([
                "user_id"=>$i,
                "role_id"=>$i,        
                // "register_at"=>"register_at",

            ]);
    
        }
    }
}
