@extends('layouts.calendar')
@section('title', 'カレンダー')
@section('content')
    <div class="container container-width border_b">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <h2 class ="html_title"><a href="?ym={{ $prev3 }}">&lt;&lt;&lt;&nbsp;&nbsp;</a><a href="?ym={{ $prev2 }}">&lt;&lt;&nbsp;&nbsp;</a><a href="?ym={{ $prev1 }}">&lt;&nbsp;&nbsp;</a>
                {{ $html_title }}
                <a href="?ym={{ $next1 }}">&nbsp;&nbsp;&gt;</a><a href="?ym={{ $next2 }}">&nbsp;&nbsp;&gt;&gt;</a><a href="?ym={{ $next3 }}">&nbsp;&nbsp;&gt;&gt;&gt;</a></h2>
            </div>
        </div>  
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
                                <th>{{ $dayOfWeek }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;?>
                        @foreach ($dates as $date)
                            @if ($date->dayOfWeek == 0)
                                <tr>
                            @endif
                            @if ($date->format('Y/m/d') == $today && $date->month == $currentMonth)
                                <td class="today td_day">
                                    <a class="a_color a_day" href='input/expenditure/create?date={{ $date->format('Y/m/d')}}'>{{ $date->day }}</a>
                                    @if($income_day_sums[$i] != 0)
                                        <p class="income_money">{{ $income_day_sums[$i] }}</p>
                                    @endif  
                                    @if($expenditure_day_sums[$i] != 0)
                                        <p class="expenditure_money">{{ $expenditure_day_sums[$i] }}</p>
                                    @endif
                                </td>
                            @else
                                @if ($date->month != $currentMonth)                    
                                    <td class="bg_day"> 
                                        <div class="a_color a_day bg_day">{{ $date->day }}</div>
                                    </td>
                                @else
                                    <td class="td td_day">
                                        <a class="a_color a_day" href='input/expenditure/create?date={{ $date->format('Y/m/d')}}'>{{ $date->day }}</a>
                                        @if($income_day_sums[$i] != 0)
                                            <p class="income_money">{{ $income_day_sums[$i] }}</p>
                                        @endif    
                                        @if($expenditure_day_sums[$i] != 0)
                                            <p class="expenditure_money">{{ $expenditure_day_sums[$i] }}</p>
                                        @endif
                                    </td>
                                @endif 
                            @endif
                            @if ($date->dayOfWeek == 6)
                                </tr>
                            @endif
                            <?php $i++;?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-4 text-center">
                <h3 class="text_input_text"><i class="fas fa-money-bill"></i> 収入</h3>
                <div class="text_input_money blue">{{ $income_month_sum }}円</div>
            </div> 
            <div class="col-lg-4 text-center">
                <h3 class="text_input_text"><i class="fas fa-money-bill-wave"></i> 支出</h3>
                <div class="text_input_money red">{{ $expenditure_month_sum }}円</div>
            </div>   
            <div class="col-lg-4 text-center">
                <h3 class="text_input_text"><i class="fas fa-wallet"></i> 合計</h3>
                <div class="text_input_money">{{ $input_month_sum }}円</div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-6 text-center">
                <h3 class="text_input_text"><i class="fas fa-credit-card"></i> 持越</h3>
                <div class="text_input_money">{{$carryover}}円</div>
            </div>
            <div class="col-lg-6 text-center">
                <h3 class="text_input_text"><i class="fas fa-money-check"></i> 残高</h3>
                <div class="text_input_money">{{$balance}}円</div>
            </div>
        </div>    
        <div class="row">
            <div class="col-lg-6">
                <h3 class="col-lg-12 text-center text_income"><i class="fas fa-money-bill"></i> 収入</h3>
                @foreach ($dates as $date)
                    @foreach ($incomes as $income)
                        @if(false !== strpos($income->date,$ym) && $income->date == $date->format('Y-m-d'))
                            <a href="input/income/edit?id={{ $income->id }}">
                                <div class="row income_list">
                                    <li class="col-lg-2">{{ $income->date }}</li>
                                    <li class="col-lg-2">{{ $icategories[$income->category_id-1]->name }}</li>
                                    <li class="col-lg-5">{{ $income->memo }}</li>
                                    <li class="col-lg-3 text-right income_money_color">{{ $income->money }}円</li>
                                </div>   
                            </a>    
                        @endif 
                    @endforeach
                @endforeach
            </div>
            <div class="col-lg-6">
                <h3 class="col-lg-12 text-center text_expenditure"><i class="fas fa-money-bill-wave"></i> 支出</h3>
                @foreach ($dates as $date)
                    @foreach ($expenditures as $expenditure)
                        @if(false !== strpos($expenditure->date,$ym) && $expenditure->date == $date->format('Y-m-d'))
                            <a href="input/expenditure/edit?id={{ $expenditure->id }}">
                                <div class="row income_list">
                                    <li class="col-lg-2">{{ $expenditure->date }}</li>
                                    <li class="col-lg-2">{{ $ecategories[$expenditure->category_id-1]->name }}</li>
                                    <li class="col-lg-5">{{ $expenditure->memo }}</li>
                                    <li class="col-lg-3 text-right expenditure_money_color">{{ $expenditure->money }}円</li>
                                </div>   
                            </a>    
                        @endif 
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection