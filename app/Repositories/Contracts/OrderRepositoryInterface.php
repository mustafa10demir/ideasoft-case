<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    /**
     * @return Collection
     */
    public function list(): Collection;

    /**
     * @param $data
     *
     * @return mixed
     */
    public function storeOrder( $data ): mixed;

    /**
     * @param $item
     * @param $orderId
     *
     * @return void
     */
    public function storeOrderItem( $item, $orderId ): void;

    /**
     * @param $id
     *
     * @return void
     */
    public function destroy( $id ): void;
}
