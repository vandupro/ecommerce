<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;
class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        for($i=0; $i<20;$i++){
            DB::table('users')->insert([
                "name"=>$faker->name,
                "email"=>$faker->email,
                "phone_number"=>$faker->phoneNumber,
                "profile"=>"admin",
                "image"=>$faker->image,
                "email"=>$faker->email,
                "email"=>$faker->email,
                "password"=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                "register_at"=>"2021-07-13",
                'status'=>rand(0,1),
                "last_login"=>"2021-07-13",
                "intro"=>"register_at",
                "email_verified_at"=>null,
                // "register_at"=>"register_at",

            ]);
    
        }
    }
}
// $table->increments('id');
// $table->string('name');/////////
// $table->string('phone_number');/////
// $table->date('register_at');///
// $table->date('last_login');///
// $table->text('intro');///
// $table->text('profile');///
// $table->string('image', 200);///
// $table->string('email')->unique();///
// $table->timestamp('email_verified_at')->nullable();
// $table->string('password');////
// $table->unsignedInteger('status')->default(0);///
// $table->rememberToken();
// $table->timestamps();