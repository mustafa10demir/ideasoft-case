<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    private OrderService $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct( OrderService $orderService )
    {
        $this->orderService = $orderService;
    }

    /**
     * @return false|JsonResponse
     */
    public function list(): false|JsonResponse
    {
        $orderList = $this->orderService->list();
        if ( $orderList ) {
            return response()->json( $orderList );
        }

        return response()->json( null, 204 );
    }
}
