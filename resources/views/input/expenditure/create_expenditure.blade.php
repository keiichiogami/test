@extends('layouts.navigation')
@section('title', '入力画面')
@section('content')
    <div class="container">
        <div class="row " >
            <div class="col-sm-7 text-center mx-auto">
                <a href="/input/income/create?date={{$date}}">支出</a>
                <p class="text">収入</p>
            </div>
        </div>  
    </div>
@endsection