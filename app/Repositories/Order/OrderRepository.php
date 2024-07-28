<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
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

    /**
     * Get Product For by ID
     *
     * @param $id
     *
     * @return mixed
     */
    public function getProductById( $id ): mixed
    {
        return Product::findOrFail( $id );
    }

    /**
     * Product Stock Update
     *
     * @param $productId
     * @param $quantity
     *
     * @return void
     */
    public function updateProductStock( $productId, $quantity ): void
    {
        $product        = $this->getProductById( $productId );
        $product->stock = $product->stock - $quantity;
        $product->save();
    }

    /**
     * User Revenue Update
     *
     * @param $userId
     * @param $revenue
     *
     * @return void
     */
    public function updateUserRevenue( $userId, $revenue ): void
    {
        $user          = User::findOrFail( $userId );
        $user->revenue = $user->revenue + $revenue;
        $user->save();
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
        return Order::where( [
            'id' => $id,
        ] )->with( 'items.product' )->first();
    }
}
