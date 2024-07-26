<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;

/**
 * Login Api
 */
Route::post( 'login', [ LoginController::class, 'login' ] );

/**
 * JWT Token Middleware
 */
Route::middleware( [ 'jwtToken' ] )->group( function () {

    /**
     * Orders Group Api
     */
    Route::prefix( 'orders' )->group( function () {
        Route::get( '/list', [ OrderController::class, 'list' ] );
        Route::post('/', [ OrderController::class, 'store' ]);
    } );
} );
