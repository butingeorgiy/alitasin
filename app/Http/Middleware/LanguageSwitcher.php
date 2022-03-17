<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $locale = $request->cookie('locale', 'ru');

        if (!in_array($locale, ['en', 'ru', 'tr', 'ua'])) {
            $locale = 'ru';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
