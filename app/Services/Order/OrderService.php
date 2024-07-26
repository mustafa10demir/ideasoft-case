<?php

namespace App\Services\Order;

use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Collection;

class OrderService
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct( OrderRepositoryInterface $orderRepository )
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return false|Collection
     */
    public function list(): false|Collection
    {
        $orders = $this->orderRepository->list();
        if ( ! $orders->isEmpty() ) {
            return $orders->map( function ( $order ) {
                return [
                    'id'         => $order->id,
                    'customerId' => $order->customerId,
                    'items'      => $order->items->map( function ( $item ) {
                        return [
                            'productId' => $item->productId,
                            'quantity'  => $item->quantity,
                            'unitPrice' => number_format( $item->unitPrice, 2 ),
                            'total'     => number_format( $item->total, 2 ),
                        ];
                    } ),
                    'total'      => number_format( $order->total, 2 ),
                ];
            } );
        }

        return false;
    }
}
