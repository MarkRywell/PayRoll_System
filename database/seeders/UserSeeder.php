<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        User::create([
            "email" => 'markgaje@gmail.com',
            "password" => Hash::make('mark123'),
            "name" => 'Mark Gaje',
            "position" => 'CEO',
            "address_id" => 1,
            "contact_number" => "09265567313",
            "role_id" => 1,
            "status" => true
        ]);

        User::create([
            "email" => 'janri@gmail.com',
            "password" => Hash::make('janri123'),
            "name" => 'John Ray Canete',
            "position" => 'Frontend Developer',
            "address_id" => 1,
            "contact_number" => "09177035723",
            "rate" => 250,
            "role_id" => 2,
            "status" => true
        ]);

        $address_id = Address::inRandomOrder()->value('id');
        
        echo $address_id;
        
        User::factory(5)->create(['position' => 'Employee', 'role_id' => 2, 'status' => true]);
       
    }
}
