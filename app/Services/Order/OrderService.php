<?php

namespace App\Services\Order;

use App\Repositories\Contracts\OrderRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     *  OrderService constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct( OrderRepositoryInterface $orderRepository )
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     *  Get the list of orders.
     *
     *  @return false|Collection
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

    /**
     * Store a newly created order in the database.
     *
     * @param $request
     *
     * @return bool
     */
    public function store( $request ): bool
    {
        try {
            $order = $this->orderRepository->storeOrder( [
                'customerId' => Auth::id(),
                'total'      => $request->total ?? 0,
            ] );
            foreach ( $request->items as $item ) {
                $this->orderRepository->storeOrderItem( $item, $order->id );
            }

            return true;
        } catch ( Exception $e ) {
            return false;
        }
    }

    /**
     * Remove the specified order from the database.
     *
     * @param $id
     *
     * @return bool
     */
    public function destroy( $id ): bool
    {
        try {
            $this->orderRepository->destroy( $id );

            return true;
        } catch ( Exception $e ) {
            return false;
        }
    }
}
