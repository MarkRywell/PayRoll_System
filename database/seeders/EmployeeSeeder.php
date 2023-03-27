<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $employees = [
            // [
                // 'name' => 'Mark Gaje',
                // 'email' => 'markgaje@gmail.com',
                // 'password' => Hash
            // ]
        // ];

        Employee::factory(1)->create(["email" => 'markgaje@gmail.com', "password" => Hash::make('mark123'), "name" => 'Mark Gaje', 'role_id' => 1, "status" => true]);
    }
}
