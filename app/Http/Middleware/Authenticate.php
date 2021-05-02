<?php

namespace App\Http\Middleware;

use App\Facades\Auth;
use Closure;
use Exception;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $accountType
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next, ...$accountType)
    {
        $authStatus = Auth::check(array_map(function ($item) { return $item; }, $accountType ?: ['1']));

        if ($authStatus !== true) {
            if ($request->is('api/*')) {
                throw new Exception(__('messages.user-not-authorized'));
            } else {
                return redirect('/#login');
            }
        }

        return $next($request);
    }
}
