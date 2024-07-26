<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderItems;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{

    /**
     * Get the list of orders with their items.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return Order::with( 'items' )->get();
    }

    /**
     * Store a newly created order in the database.
     *
     * @param $data
     *
     * @return mixed
     */
    public function storeOrder( $data ): mixed
    {
        return Order::create(
            $data
        );
    }

    /**
     * Store a newly created order item in the database.
     *
     * @param $item
     * @param $orderId
     *
     * @return void
     */
    public function storeOrderItem( $item, $orderId ): void
    {
        OrderItems::create( [
            'orderId'   => $orderId,
            'productId' => $item['productId'],
            'quantity'  => $item['quantity'],
            'unitPrice' => $item['unitPrice'],
            'total'     => $item['total'],
        ] );
    }

    /**
     * Remove the specified order and its items from the database.
     *
     * @param $id
     *
     * @return void
     */
    public function destroy( $id ): void
    {
        $order = Order::findOrFail( $id );
        $order->items()->delete();
        $order->delete();
    }
}
