<?php

namespace Database\Seeders;

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
            "role_id" => 1,
            "status" => true
        ]);

        User::create([
            "email" => 'janri@gmail.com',
            "password" => Hash::make('janri123'),
            "name" => 'John Ray Canete',
            "position" => 'Frontend Developer',
            "role_id" => 2,
            "status" => true
        ]);
        
        User::factory(5)->create(['position' => 'Employee', 'role_id' => 2, 'status' => true]);
        // $users = [
        //     [
                // "email" => 'markgaje@gmail.com',
                // "password" => Hash::make('mark123'),
                // "name" => 'Mark Gaje',
                // "role_id" => 1,
                // "status" => true
        //     ],
        //     [
        //         "email" => 'janri@gmail.com',
        //         "password" => Hash::make('janri123'),
        //         "name" => 'John Ray Canete',
        //         "role_id" => 2,
        //         "status" => true
        //     ]
        //     ];

        //     User::create($users);

            // DB::table('users')->insert($users);

        // User::factory(1)->create(["email" => 'markgaje@gmail.com', "password" => Hash::make('mark123'), "name" => 'Mark Gaje', 'role_id' => 1, "status" => true]);
    }
}
