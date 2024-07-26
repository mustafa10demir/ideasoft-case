<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderItems;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{

    /**
     * @return Collection
     */
    public function list(): Collection
    {
        return Order::with( 'items' )->get();
    }

    /**
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
}
