@extends('layouts.navigation')
@section('title', 'カレンダー')
@section('content')
    <div class="container">
        <h2><a href="?ym={{$prev}}">&lt;&nbsp;&nbsp;</a>{{$html_title}}<a href="?ym={{$next}}">&nbsp;&nbsp;&gt;</a></h3>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                        <th>{{ $dayOfWeek }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=0;
                ?>
                @foreach ($dates as $date)
                    @if ($date->dayOfWeek == 0)
                        <tr>
                    @endif
                    @if ($date->format('Y/m/d') == $today && $date->month == $currentMonth)
                        <td class="today td_day">
                            <a class="a_color a_day" href='input/income/create?date={{ $date->format('Y/m/d')}}'>{{ $date->day }}</a>
                            @if($income::where('date',$date->format('Y/m/d'))->sum('money') != 0)
                                <p class="money">{{$income::where('date',$date->format('Y/m/d'))->sum('money')}}</p>
                            @endif  
                        </td>
                    @else
                        @if ($date->month != $currentMonth)                    
                            <td class="bg_day"> 
                                <div class="a_color a_day bg_day">{{ $date->day }}</div>
                            </td>
                        @else
                            <td class="td td_day" >
                                <a class="a_color a_day" href='input/income/create?date={{ $date->format('Y/m/d')}}'>{{ $date->day }}</a>
                                @if($day_sums[$i] != 0)
                                    <p class="money">{{$day_sums[$i]}}</p>
                                @endif    
                            </td>
                        @endif 
                    @endif
                    @if ($date->dayOfWeek == 6)
                        </tr>
                    @endif
                    <?php
                        $i++;
                    ?>
                    
                @endforeach
            </tbody>
        </table>
        
        <div class="row">
            <div class="col-lg-4 text-center">
                <div>収入</div>
                
                    @if ($month_sum > 0) 
                        <div class="text_input_money">{{$month_sum}}円</div>
                    @endif
                
            </div> 
            <div class="col-lg-4 text-center">
                <div>収入</div>
                <div class="text_input_money">{{$income::all()->sum('money')}}円</div>
            </div>   
            <div class="col-lg-4 text-center">
                <div>収入</div>
                <div class="text_input_money">{{$money}}円</div>
            </div>  
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <h3 class="col-lg-12 text-center">支出</h3>
                @foreach ($dates as $date)
                    @foreach ($incomes as $income)
                        @if(false !== strpos($income->date,$ym)  && $income->date ==$date->format('Y-m-d'))
                            <a href="a">
                                <div class="row income_list">
                                    <li class="col-lg-2">{{$income->date}}</li>
                                    <li class="col-lg-2">{{$categorys_i[$income->category_id-1]->name}}</li>
                                    <li class="col-lg-5">{{$income->memo}}</li>
                                    <li class="col-lg-3 text-right">{{$income->money}}円</li>
                                </div>   
                            </a>    
                        @endif 
                    @endforeach
                @endforeach
            </div>
            <div class="col-lg-6">
                <h3 class="col-lg-12 text-center">支出</h3>
                @foreach ($dates as $date)
                    @foreach ($incomes as $income)
                        @if(false !== strpos($income->date,$ym)  && $income->date ==$date->format('Y-m-d'))
                            <a href="a">
                                <div class="row income_list">
                                    <li class="col-lg-2">{{$income->date}}</li>
                                    <li class="col-lg-2">{{$income->category_id}}</li>
                                    <li class="col-lg-5">{{$income->memo}}</li>
                                    <li class="col-lg-3 text-right">{{$income->money}}円</li>
                                </div>   
                            </a>    
                        @endif 
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
    
@endsection
