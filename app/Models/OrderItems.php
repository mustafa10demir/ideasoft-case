<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'orderId',
        'productId',
        'quantity',
        'unitPrice',
        'total',
        'created_at',
        'updated_at',
    ];


    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo( Order::class, 'orderId' );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
