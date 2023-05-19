<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   

        $address = [
            'street' => 'Corrales Extension',
            'city' => 'Cagayan de Oro',
            'zip_code' => 9000
        ];

        Address::create($address);
        Address::factory(5);
    }
}
