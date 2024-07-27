<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create( 'offer_discounts', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'offer_id' )->nullable();
            $table->foreign( 'offer_id' )->references( 'id' )->on( 'offers' );
            $table->unsignedBigInteger( 'percent_discount' )->nullable();
            $table->boolean( 'is_total' )->nullable();
            $table->unsignedBigInteger( 'is_free_product_count' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'offer_discounts' );
    }
};
