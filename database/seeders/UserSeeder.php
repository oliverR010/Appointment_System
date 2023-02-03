<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\appointments;
use App\Models\services;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;




class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'firstname' => Str::random(10),
            'middlename'=> Str::random(10),
            'lastname'=> Str::random(10),
            'gender'=> Str::random(10),
            'birthdate'=> Str::random(10),
            'age'=> Str::random(10),
           'identification'=> Str::random(10),
           'identificationtype'=> Str::random(10),
           'contactnumber'=> Str::random(10),
           'address'=> Str::random(10),
           'email'=> "oliverjansen16@gmail.com",
           'status'=> "approved",
          'account_type'=>"user",
          'password' =>bcrypt('qweqweqwe'),
        ]);
        
        // User::factory()->times(50)->create();
        // appointments::factory()->times(50)->create();
        // services::factory()->times(10)->create();


    }
}
