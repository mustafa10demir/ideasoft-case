<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferDiscount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'offer_id',
        'percent_discount',
        'is_total',
        'is_free_product_count',
    ];


    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo( Offer::class, 'offer_id' );
    }
}
