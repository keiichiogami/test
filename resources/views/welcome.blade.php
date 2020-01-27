<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>家計簿「極み」</title>

        <script src="{{ secure_asset('js/app.js') }}" defer></script>

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/welcome.css') }}" rel="stylesheet">
    <!--    <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>　-->
    </head>
    <body>
        <div class="container" style="background:white;">
            <div class="row">
                <div class="col-lg-12">
                    <h1 >家計簿「極み」</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>はじめての方はこちら</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="btnarea">
                        <a href="{{ route('register') }}"class="btn btn-primary">アカウントの作成</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>アカウントをお持ちの方はこちら</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="btnarea">
                        <a href="{{ route('login') }}" class="btn btn-primary">ログイン</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<!--<div class="flex-center position-ref full-height">-->
        <!--    @if (Route::has('login'))-->
        <!--        <div class="top-right links">-->
        <!--            @auth-->
        <!--                <a href="{{ url('/home') }}">Home</a>-->
        <!--            @else-->
        <!--                <a href="{{ route('login') }}">Login</a>-->

        <!--                @if (Route::has('register'))-->
        <!--                    <a href="{{ route('register') }}">Register</a>-->
        <!--                @endif-->
        <!--            @endauth-->
        <!--        </div>-->
        <!--    @endif-->

        <!--    <div class="content">-->
        <!--        <div class="title m-b-md">-->
        <!--            Laravel-->
        <!--        </div>-->

        <!--        <div class="links">-->
        <!--            <a href="https://laravel.com/docs">Docs</a>-->
        <!--            <a href="https://laracasts.com">Laracasts</a>-->
        <!--            <a href="https://laravel-news.com">News</a>-->
        <!--            <a href="https://blog.laravel.com">Blog</a>-->
        <!--            <a href="https://nova.laravel.com">Nova</a>-->
        <!--            <a href="https://forge.laravel.com">Forge</a>-->
        <!--            <a href="https://vapor.laravel.com">Vapor</a>-->
        <!--            <a href="https://github.com/laravel/laravel">GitHub</a>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->