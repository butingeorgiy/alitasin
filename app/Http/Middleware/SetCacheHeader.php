<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCacheHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        $response->header('Cache-Control', 'public, must-revalidate, max-age=604800');

        return $response;
    }
}
