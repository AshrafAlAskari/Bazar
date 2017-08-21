<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class JWTTokenAuth
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
        $token = $request->header('Authorization');

        if(!$token)
        return response()->json(['errors' =>['Invalid Token']], 422);

        try {
            $user = JWTAuth::toUser($token);
            if(!$user)
            return response()->json(['errors' =>['Invalid Token']], 401);
            
        } catch (JWTException $e) {
            return response()->json(['errors' =>['Invalid Token']], 422);

        }


        return $next($request);
    }
}
