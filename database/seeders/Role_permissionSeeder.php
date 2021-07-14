<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;
class Role_permissionSeeder extends Seeder
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
            DB::table('permissions_roles')->insert([
                "permission_id"=>rand(1,20),
                "role_id"=>$i,
            
                // "register_at"=>"register_at",

            ]);
    
        }
    }
}
