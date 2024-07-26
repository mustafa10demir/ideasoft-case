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
     * OrderController constructor.
     *
     * @param OrderService $orderService The service responsible for handling order-related operations.
     */
    public function __construct( OrderService $orderService )
    {
        $this->orderService = $orderService;
    }

    /**
     * Get the list of orders.
     *
     * @return false|JsonResponse
     * Returns a JSON response containing the list of orders if available,
     * or a 204 No Content response if no orders are found.
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
     **
     * Store a newly created order in the database.
     *
     * @param StoreOrderRequest $request The request object containing order details.
     *
     * @return JsonResponse
     * Returns a JSON response indicating success or failure of order creation.
     */
    public function store( StoreOrderRequest $request ): JsonResponse
    {
        $storeOrder = $this->orderService->store( $request );

        if ( $storeOrder === 3 ) {
            return response()->json( [
                'error' => 'products.stock',
            ] );
        }

        if ( $storeOrder ) {
            return response()->json( [
                'message' => 'Order created successfully',
            ] );
        }

        return response()->json( [
            'error' => 'Order creation failed',
        ], 500 );
    }

    /**
     * Remove the specified order from the database.
     *
     * @param int $id The ID of the order to be deleted.
     *
     * @return JsonResponse
     * Returns a JSON response indicating success or failure of order deletion.
     */
    public function destroy( int $id ): JsonResponse
    {
        if ( $this->orderService->destroy( $id ) ) {
            return response()->json( [
                'message' => 'Order deleted successfully',
            ] );
        }

        return response()->json( [
            'error' => 'Order deletion failed',
        ], 500 );
    }
}
