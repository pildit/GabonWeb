<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">
    <link href="/css/all.css" rel="stylesheet">
    <!--Project styles -->
{{--    <link href="zenith_src/css/app.css" rel="stylesheet">--}}
    @yield('styles')
</head>
<body style="height: 100vh">
<div class="page-loader d-flex justify-content-center" id="page-loader">
    <div class="spinner-border text-success" role="status">
        <span class="sr-only">{{lang('loading')}}...</span>
    </div>
</div>
<div id="notification">
    <notifications group="server" position="bottom right" />
</div>
<header id="navigation-menu">
    <navigation-menu></navigation-menu>
</header>

<div class="main-content">
    @yield('content')
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script src="/js/all.js"></script>
<script src="/js/app.js"></script>
@yield('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.Pages.render('navigation-menu');
    });
</script>
</body>
</html>
