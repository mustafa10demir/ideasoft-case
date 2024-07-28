<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customerId',
        'total',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the order items for the order.
     */
    public function items()
    {
        return $this->hasMany( OrderItems::class, 'orderId' );
    }
}
