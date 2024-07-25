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
        Schema::create( 'order_items', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'orderId' );
            $table->foreign( 'orderId' )->references( 'id' )->on( 'orders' );
            $table->unsignedBigInteger( 'productId' );
            $table->foreign( 'productId' )->references( 'id' )->on( 'products' );
            $table->integer( 'quantity' );
            $table->integer( 'unitPrice' );
            $table->integer( 'total' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'order_items' );
    }
};
