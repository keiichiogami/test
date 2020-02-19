@extends('layouts.input')
@section('title', '収入の編集画面')
@section('content')
    <div class="container border_b">
        <div class="row">
            <div class="col-lg-5 mx-auto form-border form_input">
                <h2 class="text-center form-title"><i class="fas fa-pen"></i> 入力してください</h2>
                <form action="{{ action('Input\IncomeController@update') }}" method="post" enctype="multipart/form-data">
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
                                <input type="text" class="form-control datepicker" name="date" value="{{ date('Y/m/d', strtotime($income->date)) }}">
                            @else
                                <input type="text" class="form-control datepicker" name="date" value="{{ old('date') }}">
                            @endif    
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-5 label-text">金額<span class="required_input">*</span></label>
                        <div class="col-lg-7">
                            <div class="input-group">
                                <input id="yourInput" type="number" class="form-control" name="money" value="{{ $income->money }}" placeholder="0" min="0" max="100000000">
                                <div class="input-group-append"><div class="input-group-text">円</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-5 label-text">カテゴリー<span class="required_input">*</span></label>
                        <div class="col-lg-4">
                            <select name="category_id">
                                <?php $i=0;?>
                                @foreach($icategories as $category)
                                    @if($i==0)
                                        <option value="{{ $category->id = $income->category_id }}">{{ $icategories[$income->category_id-1]->name }}</option>  
                                        <?php $i++;?>
                                    @endif 
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>    
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-5 label-text">メモ</label>
                        <div class="col-lg-7">
                            <textarea class="form-control" name="memo" rows="2" placeholder="（例）服2着を購入"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 text-right">
                            <a class="" href="/input/income/category_create">新規カテゴリーの作成</a>
                        </div>   
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 text-center">
                            <input type="hidden" name="id" value="{{ $income->id }}">
                            <input type="submit" class="btn btn-primary btn_top" value="支出を上書きする">
                        </div>   
                        <div class="col-sm-6 text-center">
                             <a class="income_delete" href="{{ action('Input\IncomeController@delete', ['id' => $income->id]) }}">削除する</a>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
    </div>
    
    <!--カレンダー-->
    <script>
      $(function() {
        $(".datepicker").datepicker();
        $("#datepicker").datepicker("option", "showOn", 'button');
        $("#datepicker").datepicker("option", "buttonImageOnly", true);
      });
    </script> 

    <!--電卓-->
    <script type="text/javascript"> 
        $('#yourInput').calculator();
    </script> 
@endsection

