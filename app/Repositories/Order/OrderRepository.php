<?php

namespace App\Repositories\Order;

use App\Contracts\Order\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class OrderRepository implements OrderRepositoryInterface
{

    /**
     * Get the list of orders with their items.
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return Cache::remember( 'orders_list', 600, function () {
            return Order::with( 'items' )->get();
        } );
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
        $order = Order::create( $data );
        Cache::forget( 'orders_list' );

        return $order;
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
        Cache::forget( 'orders_list' );
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
        Cache::forget( 'orders_list' );
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
        return Cache::remember( "product_{$id}", 600, function () use ( $id ) {
            return Product::findOrFail( $id );
        } );
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
        Cache::forget( "product_{$productId}" );
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
        return Cache::remember( "order_{$id}", 600, function () use ( $id ) {
            return Order::where( [ 'id' => $id ] )->with( 'items.product' )->first();
        } );
    }
}
