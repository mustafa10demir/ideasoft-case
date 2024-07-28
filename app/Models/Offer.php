<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'total_price',
        'category_id',
        'product_limit_count',
        'category_product_limit_count',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the order items for the order.
     */
    public function discount()
    {
        return $this->hasMany( OfferDiscount::class, 'offer_id' );
    }
}
