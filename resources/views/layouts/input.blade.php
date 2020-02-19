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
    <!--カレンダー-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script> 
    <!--電卓-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jcalculator/1403955268/jcalculator.js"></script>   
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/input.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/icalendar.css') }}" rel="stylesheet">
    <!--カレンダー-->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.css">
    <!--電卓-->
    <link href="{{ secure_asset('css/jcalculator.css') }}" rel="stylesheet" >
    
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <div class="container border_t">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="h1_title"><i class="far fa-clipboard"></i> 家計簿 <i class="fas fa-clipboard"></i></h1>
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