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
        abort(503);

        $locale = $request->cookie('locale', 'ru');

        if (!in_array($locale, ['en', 'ru', 'tr', 'ua'])) {
            $locale = 'ru';
        }

        \App::setLocale($locale);
        return $next($request);
    }
}
