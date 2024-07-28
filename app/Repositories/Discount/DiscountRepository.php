<?php

namespace App\Repositories\Discount;

use App\Contracts\Discount\DiscountRepositoryInterface;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class DiscountRepository implements DiscountRepositoryInterface
{
    /**
     * Get All Offer List
     *
     * @return Collection
     */
    public function getAllOffer(): Collection
    {
        return Cache::remember( 'all_offers', 600, function () {
            return Offer::all();
        } );
    }

    /**
     * Get Offer Discount
     *
     * @param $offerId
     *
     * @return mixed
     */
    public function getOfferDiscount( $offerId ): mixed
    {
        return Cache::remember( "offer_discount_{$offerId}", 600, function () use ( $offerId ) {
            return Offer::where( [ 'id' => $offerId ] )->with( 'discount' )->first();
        } );
    }
}
