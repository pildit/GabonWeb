<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>App Name - @yield('title')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="/css/all.css" rel="stylesheet">
    <!--Project styles -->
{{--    <link href="zenith_src/css/app.css" rel="stylesheet">--}}
    @yield('styles')
</head>
<body>
<header>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar" style="">
        <div class="container">
            <a class="navbar-brand text-capitalize text-success logo" href="/" style="">
                <i class="fas fa-globe-americas" style="height: 50px;width: 50px;font-size: 50px;color: rgba(13,146,32,0.9);"></i>
                Gabon
            </a>
            <button data-toggle="collapse"  class="navbar-toggler" data-target="#navcol-1">
                <span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" style="background-color: white;" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="main-content">
    @yield('content')
</div>

<script src="/js/all.js"></script>
<script src="/js/app.js"></script>
@yield('scripts')

</body>
</html>
