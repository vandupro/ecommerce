<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
     
        Model::reguard();
    //     $this->call(Categories::class);
       // $this->call(userSeeder::class);
      // $this->call(RoleUserSeeder::class);
    $this->call(RoleSeeder::class);
    // $this->call(Role_permissionSeeder::class);
        Model::reguard();
    }
}
