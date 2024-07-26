<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login( Request $request )
    {
        $credentials = $request->only( 'email', 'password' );
        if ( ! $token = Auth::attempt( $credentials ) ) {
            return response()->json( [ 'error' => 'Unauthorized' ], 401 );
        }

        return $this->respondWithToken( $token );
    }

    /**
     * @param $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken( $token )
    {
        return response()->json( [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ] );
    }

    public function test()
    {
        dd( 1 );
    }
}
