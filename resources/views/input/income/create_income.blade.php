@extends('layouts.input')
@section('title', '支出の入力画面')
@section('content')
    <div class="container">
        <div class="row " >
            <div class="col-lg-12 text-center mx-auto text_input_selection">
                <div class="text">支出</div>
                <a class="a_input" href="/input/expenditure/create?date={{$date}}">収入</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-5 mx-auto form-border">
                <h2 class="text-center form-title">入力してください</h2>
                <form action="{{ action('Input\IncomeController@create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group row">
                        <div class="col-lg-12 text-center">
                            @if (count($errors) > 0)
                                <ul>
                                    @foreach($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-lg-5 label-text">日付<span class="required_input">*</span></label>
                        <div class="col-lg-7 ">
                            @if (count($errors) == 0)
                                <input type="text" class="form-control datepicker" name="date" value="{{$date}}">
                            @else
                                <input type="text" class="form-control datepicker" name="date" value="{{old('date')}}">
                            @endif    
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-5 label-text">金額<span class="required_input">*</span></label>
                        <div class="col-lg-7">
                            <div class="input-group">
                                <input id="yourInput" type="number" class="form-control" name="money" value="{{old('money')}}" placeholder="0" min="0" max="100000000">
                                <div class="input-group-append"><div class="input-group-text">円</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-5 label-text">カテゴリー<span class="required_input">*</span></label>
                        <div class="col-lg-4">
                            <select name="category_id">
                                <option value="">選択してください&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                
                                @foreach($categorys_i as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>    
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-5 label-text">メモ</label>
                        <div class="col-lg-7">
                            <textarea class="form-control" name="memo" rows="2" placeholder="（例）服2着買った"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <input type="submit" class="btn btn-primary " value="支出を入力する">
                        </div>    
                    </div> 
                </form>
            </div>
        </div>
    </div>
    
    <!--カレンダー-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script> 
    
    <script>
      $(function() {
        $(".datepicker").datepicker();
        $("#datepicker").datepicker("option", "showOn", 'button');
        $("#datepicker").datepicker("option", "buttonImageOnly", true);
      });
    </script> 
    <!------------------------------------------------------------------------------------------------------------->

    <!--電卓-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jcalculator/1403955268/jcalculator.js"></script>

    <script type="text/javascript"> 
        $('#yourInput').calculator();
    </script> 
    <!------------------------------------------------------------------------------------------------------------->
<!--<script src="{{ secure_asset('js/app.js') }}" defer></script>-->
@endsection
