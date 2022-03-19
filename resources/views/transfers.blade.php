<!doctype html>
<html lang='{{ app()->getLocale() }}'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <script type='text/javascript' src='{{ asset('js/index.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('css/index.css') }}'>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ __('short-phrases.transfers') }}</title>
</head>
<body>
    @include('components.general.header')
    @include('components.general.hero', ['title' => __('short-phrases.transfers'), 'image' => asset('images/main-sections-bg-transfers.jpg')])
    @include('components.transfers.form')
    @include('components.general.footer')

    <!-- Popups -->
    @include('popups.login')
    @include('popups.reg')
    @include('popups.transfer-order')

    <!-- Widgets -->
    @include('widgets.click-to-call')
</body>
</html>
