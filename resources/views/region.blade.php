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
    @include('components.general.hero', ['title' => $currentRegion->name])
    @include('components.index.global-search', ['bottomBorder' => true])
    @include('components.region.popular-tours')
    @include('components.general.tours')
    @include('components.index.regions', ['title' => __('short-phrases.other-turkey-regions'), 'bottomBorder' => false])
    @include('components.general.footer')

    <!-- Popups -->
    @include('popups.login')

    <!-- Widgets -->
    @include('widgets.click-to-call')
</body>
</html>
