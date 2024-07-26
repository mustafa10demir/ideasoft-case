<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

class JWTMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle( Request $request, Closure $next )
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch ( Exception $e ) {
            if ( $e instanceof TokenInvalidException ) {
                return response()->json( [ 'status' => 'Token is Invalid' ], 401 );
            } elseif ( $e instanceof TokenExpiredException ) {
                return response()->json( [ 'status' => 'Token is Expired' ], 401 );
            } else {
                return response()->json( [ 'status' => 'Authorization Token not found' ], 401 );
            }
        }

        return $next( $request );
    }
}
