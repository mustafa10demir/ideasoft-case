<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert( [
            [
                'id'         => 1,
                'name'       => 'El Aletleri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,
                'name'       => 'Hırdavat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ] );
    }
}
