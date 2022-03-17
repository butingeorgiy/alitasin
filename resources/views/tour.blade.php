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
    <title>{{ $tour->title[App::getLocale()] }}</title>
</head>
<body class="bg-gray-50">
    @include('components.general.header')
    @include('components.tours.tour-info')
    @include('components.tours.book-form')
    @include('components.general.footer')

    <!-- Popups -->
    @include('popups.login')

    <!-- Widgets -->
    @include('widgets.click-to-call')
</body>
</html>
