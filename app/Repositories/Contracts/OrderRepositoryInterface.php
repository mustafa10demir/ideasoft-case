<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
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
}
