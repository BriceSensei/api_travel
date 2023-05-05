<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AddTokenToApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            $token = JWTAuth::fromUser(auth()->user());

            $responseData = [
                'message' => 'Token generated successfully',
                'token' => $token,
            ];

            $response->setContent($responseData);
        }

        return $response;
    }
}
