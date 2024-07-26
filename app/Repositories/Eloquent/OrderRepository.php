<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
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
}
