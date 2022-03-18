const mix = require('laravel-mix');

mix.js('resources/js/index.js', 'public/js/index.js')
    .postCss('resources/css/index.css', 'public/css/index.css', [
        require('tailwindcss')
    ]);
