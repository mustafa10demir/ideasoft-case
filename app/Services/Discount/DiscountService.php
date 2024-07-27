<?php

namespace App\Services\Discount;

use App\Repositories\Contracts\Order\DiscountRepositoryInterface;
use App\Services\Order\OrderService;

class DiscountService
{
    /**
     * @var OrderService
     */
    private OrderService $orderService;

    /**
     * @var DiscountRepositoryInterface
     */
    private DiscountRepositoryInterface $discountRepository;

    protected float $totalDiscount = 0;
    protected array $discounts;

    /**
     * Discount Service Construct
     *
     * @param OrderService $orderService
     * @param DiscountRepositoryInterface $discountRepository
     */
    public function __construct( OrderService $orderService, DiscountRepositoryInterface $discountRepository )
    {
        $this->orderService       = $orderService;
        $this->discountRepository = $discountRepository;
    }

    /**
     * Get Discount
     *
     * @param $request
     *
     * @return array
     */
    public function getDiscount( $request ): array
    {
        $order = $this->orderService->getOrderById( $request->orderId );
        if ( $order ) {
            $offerList = $this->discountController( $order );
            foreach ( $offerList as $offer ) {
                $this->discountCalculate( $order, $offer );
            }

            return [
                "orderId"         => $request->orderId,
                "discounts"       => $this->discounts,
                "totalDiscount"   => (string) $this->totalDiscount,
                "discountedTotal" => (string) ($order->total - $this->totalDiscount),
            ];
        }

        return [];
    }

    /**
     * Discount Controller
     *
     * @param $order
     *
     * @return array
     */
    public function discountController( $order ): array
    {
        $offerList = [];
        $offers    = $this->discountRepository->getAllOffer();
        if ( $offers ) {
            foreach ( $offers as $offer ) {
                $noCategoryTotalLimitCheck = ( ! $offer->category_id ) && $offer->total_price && $offer->total_price <= $order->total;
                $categoryTotalLimitCheck   = $offer->category_id && $offer->total_price && $offer->total_price <= $this->getOrderCategoryTotalPrice( $order['items'],
                        $offer->category_id );

                $categoryProductLimitCheck = $offer->category_id && $offer->product_limit_count && $this->getOrderCategoryTotalProductCount( $order['items'],
                        $offer->category_id,
                        $offer->product_limit_count );

                $categoryProductCheck = $offer->category_id && $offer->category_product_limit_count && $offer->category_product_limit_count <= $this->getOrderCategoryProductCount( $order['items'],
                        $offer->category_id );

                if ( $noCategoryTotalLimitCheck || $categoryTotalLimitCheck || $categoryProductLimitCheck || $categoryProductCheck ) {
                    $offerList[] = $offer->id;
                }

            }
        }

        return $offerList;
    }

    /**
     * Discount Calculate
     *
     * @param $order
     * @param $offerId
     *
     * @return void
     */
    public function discountCalculate( $order, $offerId ): void
    {
        $offerDiscount = $this->discountRepository->getOfferDiscount( $offerId );
        if ( $offerDiscount->discount[0]->percent_discount && $offerDiscount->discount[0]->is_total ) {
            $discountAmount = number_format( ( $order->total * $offerDiscount->discount[0]->percent_discount / 100 ),
                2 );
            $this->discountUpdate( $offerDiscount->name, $discountAmount, $order->total );
        }

        if ( $offerDiscount->discount[0]->percent_discount && ! $offerDiscount->discount[0]->is_total ) {
            $cheapestPrice  = $this->getCheapest( $order, $offerDiscount->category_id );
            $discountAmount = number_format( ( $cheapestPrice * $offerDiscount->discount[0]->percent_discount / 100 ),
                2 );
            $this->discountUpdate( $offerDiscount->name, $discountAmount, $order->total );
        }

        if ( $offerDiscount->discount[0]->is_free_product_count && $offerDiscount->discount[0]->is_free_product_count >= 1 ) {
            $freeProductPrice = $this->getFreeProduct( $order->items,
                $offerDiscount->category_id,
                $offerDiscount->product_limit_count );
            $this->discountUpdate( $offerDiscount->name, $freeProductPrice, $order->total );
        }
    }

    /**
     * Get free product
     *
     * @param $items
     * @param $categoryId
     * @param $productLimitCount
     *
     * @return int|mixed
     */
    public function getFreeProduct( $items, $categoryId, $productLimitCount )
    {
        $freeProductPrice = 0;

        foreach ( $items as $item ) {
            if ( $item->quantity >= $productLimitCount && $item->product->category == $categoryId ) {
                $freeProductPrice = $item->unitPrice;
            }
        }

        return $freeProductPrice;
    }

    /**
     * Get the cheapest product based on the category
     *
     * @param $order
     * @param $categoryId
     *
     * @return int
     */
    public function getCheapest( $order, $categoryId ): int
    {
        $unitPrice = null;
        foreach ( $order->items as $item ) {
            if ( $item->product->category == $categoryId && ( $unitPrice >= $item->unitPrice || $unitPrice == null ) ) {
                $unitPrice = $item->unitPrice;
            }
        }

        return $unitPrice ?? 0;
    }

    /**
     * Add Discount Array New Discount
     *
     * @param $name
     * @param $amount
     * @param $total
     *
     * @return void
     */
    public function discountUpdate( $name, $amount, $total ): void
    {
        $this->totalDiscount += $amount;

        $this->discounts[] = [
            "discountReason" => $name,
            "discountAmount" => (string) $amount,
            "subtotal"       => (string) ($total - $this->totalDiscount),
        ];

    }


    /**
     * Order total price for category id
     *
     * @param $items
     * @param $categoryId
     *
     * @return int|mixed
     */
    public function getOrderCategoryTotalPrice( $items, $categoryId ): mixed
    {
        $total = 0;
        foreach ( $items as $item ) {
            if ( $item->product->category == $categoryId ) {
                $total += $item->total;
            }
        }

        return $total;
    }

    /**
     * Checks the total count of products in the specified category and determines if the specified limit has been reached.
     *
     * @param $items
     * @param $categoryId
     * @param $limit
     *
     * @return bool
     */
    public function getOrderCategoryTotalProductCount( $items, $categoryId, $limit ): bool
    {
        $total = false;
        foreach ( $items as $item ) {
            if ( $item->product->category == $categoryId && $item->quantity == $limit ) {
                $total = true;
            }
        }

        return $total;
    }

    /**
     * Get product count for category id
     *
     * @param $items
     * @param $categoryId
     *
     * @return int
     */
    public function getOrderCategoryProductCount( $items, $categoryId ): int
    {
        $total = 0;
        foreach ( $items as $item ) {
            if ( $item->product->category == $categoryId ) {
                $total += $item->quantity;
            }
        }

        return $total;
    }

}
