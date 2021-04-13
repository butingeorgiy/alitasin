<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersResolutionProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/RussianDeclensionsResolving.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
