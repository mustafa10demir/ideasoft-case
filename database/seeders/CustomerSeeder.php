<?php

namespace Database\Seeders;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert( [
            [
                'id'      => 1,
                'name'    => 'Türker Jöntürk',
                'since'   => Carbon::create( '2014', '06', '28' ),
                'revenue' => 492.12,
            ],
            [
                'id'      => 2,
                'name'    => 'Kaptan Devopuz',
                'since'   => Carbon::create( '2015', '01', '15' ),
                'revenue' => 1505.95,
            ],
            [
                'id'      => 3,
                'name'    => 'İsa Sonuyumaz',
                'since'   => Carbon::create( '2016', '02', '11' ),
                'revenue' => 0.00,
            ],
        ] );
    }
}
