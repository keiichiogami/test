@extends('layouts.input')
@section('title', '収入のカテゴリーの作成')
@section('content')
    <div class="container border_b">
        <div class="row">
            <div class="col-lg-4 mx-auto  form_input">
                <form action="{{ action('Input\IncomeController@category_create') }}" method="post" enctype="multipart/form-data">
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
                        <div class="col-lg-8 ">
                             <input type="text" class="form-control" name="name" placeholder="新規カテゴリー" >
                        </div>
                        <div class="col-lg-4 text-center">
                            <!--<input type="hidden" name="id" value="">-->
                            <input type="submit" class="btn btn-primary btn_p_top" value="保存する">
                        </div>   
                    </div>
                </form>
            </div>    
        </div>       
        <div class="row">
            <div class="col-lg-4 mx-auto ">
                @foreach($icategories as $category)
                    @if($category->id % 3 == 1)
                        <div class="row text-center category_border">
                            @if($category->id == 1)
                                <li class="col-lg-6">{{$category->name}}</li>
                            @else
                                <li class="col-lg-6">{{$category->name}}</li>
                                <li class="col-lg-6 "><a href="{{action('Input\ExpenditureController@category_delete', ['id' => $category->id]) }}">削除する</a></li>
                            @endif
                        </div> 
                    @endif    
                @endforeach
            </div> 
            <div class="col-lg-4 mx-auto ">
                @foreach($icategories as $category)
                    @if($category->id % 3 == 2)
                        <div class="row text-center category_border">
                                <li class="col-lg-6">{{$category->name}}</li>
                                <li class="col-lg-6 "><a href="{{action('Input\IncomeController@category_delete', ['id' => $category->id]) }}">削除する</a></li>
                        </div> 
                    @endif    
                @endforeach
            </div> 
            <div class="col-lg-4 mx-auto ">
                @foreach($icategories as $category)
                    @if($category->id % 3 == 0)
                        <div class="row text-center category_border">
                                <li class="col-lg-6">{{$category->name}}</li>
                                <li class="col-lg-6 "><a href="{{action('Input\IncomeController@category_delete', ['id' => $category->id]) }}">削除する</a></li>
                        </div> 
                    @endif    
                @endforeach
            </div>    
        </div>    
    </div>    
@endsection    