<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token !== config('api.token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
