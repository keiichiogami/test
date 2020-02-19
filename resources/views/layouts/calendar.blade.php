<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/calendar.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/wcalendar.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/input.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/report.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css">
    
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <div class="container border_t">
        <div class="row">
            
            <div class="col-lg-2">
            </div>    
            <div class="col-lg-8">
                <h1 class="h1_title"><i class="far fa-clipboard"></i> 家計簿 <i class="fas fa-clipboard"></i></h1>
                <!--<h1 class="h1_title"><img  src="/images/タイトル.png" alt="logo"></h1>-->
            </div>
            <div class="col-lg-2">
                @guest
                    @if (Route::has('register'))
                        <a class=" nav-link" href="{{ route('register') }}">{{ __('messages.Register') }}</a>
                    @endif
                @else
                    <a id="navbarDropdown" class="text-right nav-float nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="fas fa-user-circle"> </i> {{ Auth::user()->name }}さん <span class="caret"></span></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('messages.Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>
        </div>
        <div class="row navbar">
            <div class="col-lg-4">
                <a href="/input/expenditure/create" class="nav"><i class="fas fa-pen"></i> 入力</a>
            </div>
            <div class="col-lg-4">
                <a href="/calendar" class="nav"><i class="far fa-calendar-alt"></i> カレンダー</a>
            </div>
            <div class="col-lg-4 as">
                <a href="/report/month_report" class="nav"><i class="fas fa-archive"></i> レポート</a>
            </div>
        </div>
     
    </div>  
    @yield('content')
</body>
</html>