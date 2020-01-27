@extends('layouts.navigation')
@section('title', 'カレンダー')
@section('content')
    <div class="container">
        <h3><a href="?yn={{$prev}}">&lt;</a>{{$html_title}}<a href="?yn={{$next}}">&gt;</a></h3>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                        <th>{{ $dayOfWeek }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($dates as $date)
                    @if ($date->dayOfWeek == 0)
                        <tr>
                    @endif
                    
                    @if ($date->format('Y-n-j') == $today)
                        <td class="today td_day">
                            <a class="a_color a_day" href='input/income/create?date={{ $date->format('Y-n-j').$week[$date->format('w')]}}'>{{ $date->day }}</a>
                            <p class="money">{{$income::where('date',$date->format('Y-n-j'))->value('money')}}</p>
                        </td>
                    @else
                        @if ($date->month != $currentMonth)                    
                            <td class="bg_day"> 
                                <div class="a_color a_day">{{ $date->day }}</div>
                            </td>
                        @else
                            <td class="td td_day" >
                                <a class="a_color a_day" href='input/income/create?date={{ $date->format('Y-n-j').$week[$date->format('w')]}}'>{{ $date->day }}</a>
                                <p class="money">{{$income::where('date',$date->format('Y-n-j'))->value('money')}}</p>
                            </td>
                        @endif 
                    @endif
                    
                    @if ($date->dayOfWeek == 6)
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        
        <div class="col-lg-12">
            @foreach ($incomes as $income)
                @if($income->date)
                    <a href="a">
                        <div class="row income_list">
                            <li class="col-lg-2">{{$income->date}}</li>
                            <li class="col-lg-2">{{$income->category_id}}</li>
                            <li class="col-lg-6">{{$income->memo}}</li>
                            <li class="col-lg-2 text-right">{{$income->money}}円</li>
                        </div>   
                    </a>    
                @endif    
            @endforeach
        </div>
    </div>    
        {{$today}}
@endsection