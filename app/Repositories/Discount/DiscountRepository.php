<?php

namespace App\Repositories\Discount;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Collection;

class DiscountRepository
{
    /**
     * Get All Offer List
     *
     * @return Collection
     */
    public function getAllOffer(): Collection
    {
        return Offer::all();
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
        return Offer::where( [
            'id' => $offerId,
        ] )->with( 'discount' )->first();
    }
}
