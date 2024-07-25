<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call( [
            CategorySeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            Orders::class,
        ] );

        User::factory()->create( [
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ] );
    }
}
