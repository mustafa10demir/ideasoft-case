<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
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

    /**
     * @param StoreOrderRequest $request
     *
     * @return JsonResponse
     */
    public function store( StoreOrderRequest $request ): JsonResponse
    {
        if ( $this->orderService->store( $request ) ) {
            return response()->json( [
                'message' => 'Order created successfully',
            ] );
        }

        return response()->json( [
            'error' => 'Order creation failed',
        ], 500 );
    }
}
