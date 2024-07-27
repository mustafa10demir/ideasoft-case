<?php

namespace App\Repositories\Eloquent\Discount;

use App\Models\Offer;
use App\Models\OfferDiscount;
use App\Repositories\Contracts\Order\DiscountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DiscountRepository implements DiscountRepositoryInterface
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
