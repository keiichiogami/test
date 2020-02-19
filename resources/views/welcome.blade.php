<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>家計簿</title>

        <script src="{{ secure_asset('js/app.js') }}" defer></script>

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/welcome.css') }}" rel="stylesheet">
        
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body>
        <div class="container" style="background:white;">
            <div class="row ">
                <div class="col-lg-8 mx-auto border_w">
                    <div class="col-lg-12">
                        <h1><i class="far fa-clipboard"></i> 家計簿 <i class="fas fa-clipboard"></i></h1>
                    </div>
                    <div class="col-lg-12">
                        <p>はじめての方はこちら</p>
                        <div class="btnarea">
                            <a href="{{ route('register') }}"class="btn btn-primary"><i class="fas fa-user-circle"></i> 新規作成</a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <p>アカウントをお持ちの方はこちら</p>
                        <div class="btnarea">
                            <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> ログイン</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>