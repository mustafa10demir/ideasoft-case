<?php

namespace App\Services\Order;

use App\Contracts\Order\OrderRepositoryInterface;
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

    /**
     * Store a newly created order in the database.
     *
     * @param $request
     *
     * @return bool | int
     */
    public function store( $request ): bool|int
    {
        try {
            $order = $this->orderRepository->storeOrder( [
                'customerId' => Auth::id(),
                'total'      => $request->total ?? 0,
            ] );
            foreach ( $request->items as $item ) {
                $product = $this->orderRepository->getProductById( $item['productId'] );
                if ( ! $product ) {
                    return false;
                }
                if ( $product->stock < $item['quantity'] ) {
                    return 3;
                }

                $this->orderRepository->storeOrderItem( $item, $order->id );
                $this->orderRepository->updateProductStock( $product->id, $item['quantity'] );
                $this->orderRepository->updateUserRevenue( Auth::id(), $request->total );
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

    /**
     * Get Order For ID
     *
     * @param $id
     *
     * @return mixed
     */
    public function getOrderById( $id ): mixed
    {
        return $this->orderRepository->getOrderById( $id );
    }
}
