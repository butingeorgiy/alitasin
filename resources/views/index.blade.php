<!doctype html>
<html lang='{{ App::getLocale() }}'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <script type='text/javascript' src='{{ asset('js/index.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('css/index.css') }}'>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ __('page-titles.main') }}</title>
</head>
<body>
    @include('components.general.header')
    @include('components.general.hero', ['title' => __('short-phrases.tours-in-turkey')])
    @include('components.index.global-search', ['bottomBorder' => false])
    @include('components.index.main-sections')
    @include('components.index.regions', ['title' => __('short-phrases.popular-turkey-regions'), 'bottomBorder' => true])
    @include('components.general.tours')
    @include('components.index.transport')
    @include('components.general.reviews-slider')
    @include('components.general.footer')

    <!-- Popups -->
    @include('popups.login')
    @include('popups.reg')

    <!-- Widgets -->
    @include('widgets.click-to-call')
</body>
</html>
