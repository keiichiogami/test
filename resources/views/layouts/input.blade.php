<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <!--<script src="{{ secure_asset('js/app.js') }}" defer></script>-->
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/input.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/calendar1.css') }}" rel="stylesheet">
    <!--カレンダー-->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.css">
    <!--電卓-->
    <link href="{{ secure_asset('css/jcalculator.css') }}" rel="stylesheet" >

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @guest
                    @if (Route::has('register'))
                        <a class=" nav-link" href="{{ route('register') }}">{{ __('messages.Register') }}</a>
                    @endif
                @else
                    <a id="navbarDropdown" class="text-right nav-float nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->name }}さん <span class="caret"></span></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('messages.Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="h1_title">家計簿「極み」</h1>
            </div>
        </div>
        <div class="row navbar">
            <div class="col-lg-4">
                <a href="/input/income/create" class="nav">入力</a>
            </div>
            <div class="col-lg-4">
                <a href="/calendar" class="nav">カレンダー</a>
            </div>
            <div class="col-lg-4 as">
                <a href="/report/income/month_income" class="nav">レポート</a>
            </div>
        </div>
     
    </div>  
    @yield('content')
</body>
</html>