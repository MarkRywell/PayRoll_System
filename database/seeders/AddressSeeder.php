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

        $addresses = [
            [
            'street' => 'Corrales Extension',
            'city' => 'Cagayan de Oro',
            'zip_code' => '9000',
            'country' => 'Philippines'
            ],
            [
                'street' => 'Nazareth',
                'city' => 'Cagayan de Oro',
                'zip_code' => '9000',
                'country' => 'Philippines'],
            [
                'street' => 'Puntod',
                'city' => 'Cagayan de Oro',
                'zip_code' => '9000',
                'country' => 'Philippines'
            ],

        ];
        foreach($addresses as $address) {
            Address::create($address);
        }
        
        Address::factory(5)->create();
    }
}
