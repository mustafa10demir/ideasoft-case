<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    /**
     * Get the list of orders.
     *
     * @return Collection
     */
    public function list(): Collection;

    /**
     * Store a newly created order in the database.
     *
     * @param $data
     *
     * @return mixed
     */
    public function storeOrder( $data ): mixed;

    /**
     * Store a newly created order item in the database.
     *
     * @param $item
     * @param $orderId
     *
     * @return void
     */
    public function storeOrderItem( $item, $orderId ): void;

    /**
     * Remove the specified order from the database.
     *
     * @param $id
     *
     * @return void
     */
    public function destroy( $id ): void;
}
