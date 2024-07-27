<?php

namespace App\Http\Controllers\Discount;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\DiscountRequest;
use App\Services\Discount\DiscountService;

class DiscountController extends Controller
{
    /**
     * @var DiscountService
     */
    private $discountService;

    /**
     * Discount Controller Construct
     *
     * @param DiscountService $discountService
     */
    public function __construct( DiscountService $discountService )
    {
        $this->discountService = $discountService;
    }

    public function getDiscount(DiscountRequest $request)
    {
        return $this->discountService->getDiscount($request);
    }
}
