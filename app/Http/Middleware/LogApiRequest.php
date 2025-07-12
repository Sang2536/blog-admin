<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogApiRequest
{
    public function handle($request, Closure $next)
    {
        Log::info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'input' => $request->all(),
        ]);

        return $next($request);
    }
}
