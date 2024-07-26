<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert( [
            [
                'id'                => 1,
                'name'              => 'Türker Jöntürk',
                'since'             => Carbon::create( '2014', '06', '28' ),
                'revenue'           => 492.12,
                'email'             => 'turker@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make( '1234' ),
                'remember_token'    => Str::random( 10 ),
                'role'              => 2,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'id'                => 2,
                'name'              => 'Kaptan Devopuz',
                'since'             => Carbon::create( '2015', '01', '15' ),
                'revenue'           => 1505.95,
                'email'             => 'kaptan@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make( '1234' ),
                'remember_token'    => Str::random( 10 ),
                'role'              => 2,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'id'                => 3,
                'name'              => 'İsa Sonuyumaz',
                'since'             => Carbon::create( '2016', '02', '11' ),
                'revenue'           => 0.00,
                'email'             => 'isa@gmail.com',
                'email_verified_at' => now(),
                'password'          => Hash::make( '1234' ),
                'remember_token'    => Str::random( 10 ),
                'role'              => 2,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ] );
    }
}
