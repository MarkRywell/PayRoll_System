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
        // $users = [
            // [
                // "email" => 'markgaje@gmail.com',
                // "password" => Hash::make('mark123'),
                // "name" => 'Mark Gaje',
                // "role_id" => 1,
                // "status" => true
            // ]
            // ];

            // DB::table('users')->insert($users);

        User::factory(1)->create(["email" => 'markgaje@gmail.com', "password" => Hash::make('mark123'), "name" => 'Mark Gaje', 'role_id' => 1, "status" => true]);
    }
}
