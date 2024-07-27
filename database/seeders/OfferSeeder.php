<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\OfferDiscount;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Offer::create([
            "name" => '10_PERCENT_OVER_1000',
            "total_price" => 1000,
        ]);

        Offer::create([
            "name" => 'BUY_5_GET_1',
            "category_id" => 2,
            "product_limit_count" => 6,
        ]);

        Offer::create([
            "name" => '20_PERCENT_DISCOUNT_MULTI_PURCHASE',
            "category_id" => 1,
            "category_product_limit_count" => 2,
        ]);

        OfferDiscount::create([
            "offer_id" => 1,
            "percent_discount" => 10,
            "is_total" => true,
        ]);

        OfferDiscount::create([
            "offer_id" => 2,
            "is_free_product_count" => 1,
        ]);

        OfferDiscount::create([
            "offer_id" => 3,
            "percent_discount" => 20,
            "is_total" => false,
        ]);
    }
}
