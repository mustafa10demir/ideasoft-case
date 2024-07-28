<?php

namespace App\Contracts\Discount;

use Illuminate\Database\Eloquent\Collection;

interface DiscountRepositoryInterface
{
    /**
     * Get All Offer List
     *
     * @return Collection
     */
    public function getAllOffer(): Collection;

    /**
     * Get Offer Discount
     *
     * @param $offerId
     *
     * @return mixed
     */
    public function getOfferDiscount( $offerId ): mixed;
}
