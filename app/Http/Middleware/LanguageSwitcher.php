<?php

namespace App\Http\Middleware;

use Closure;

class LanguageSwitcher
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
        $locale = $request->cookie('locale', 'ru');

        if (!in_array($locale, ['en', 'ru', 'tr'])) {
            $locale = 'ru';
        }

        \App::setLocale($locale);
        return $next($request);
    }
}
