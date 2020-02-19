@extends('layouts.navigation')
@section('title', '年間レポート')
@section('content')
    <div class="container border_b">

        <div class="row ">
            <div class="col-lg-12 text-center mx-auto text_input_selection">
                <a class="a_input_income" href="/report/month_report"><i class="far fa-moon"></i> 月間</a>
                <div class="text"><i class="fas fa-moon"></i> 年間</div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class ="html_title"><a href="?ym={{ $prev3 }}">&lt;&lt;&lt;&nbsp;&nbsp;</a><a href="?ym={{ $prev2 }}">&lt;&lt;&nbsp;&nbsp;</a><a href="?ym={{ $prev1 }}">&lt;&nbsp;&nbsp;</a>
                {{ $html_title }}
                <a href="?ym={{ $next1 }}">&nbsp;&nbsp;&gt;</a><a href="?ym={{ $next2 }}">&nbsp;&nbsp;&gt;&gt;</a><a href="?ym={{ $next3 }}">&nbsp;&nbsp;&gt;&gt;&gt;</a></h2>
            </div>
        </div>  
        
        <div class="row">
            <div class="col-lg-4 text-center">
                <h3 class="text_input_text"><i class="fas fa-money-bill"></i> 収入</h3>
                <div class="text_input_money blue">{{ $icategory_day_allsum }}円</div>
            </div> 
            <div class="col-lg-4 text-center">
                <h3 class="text_input_text"><i class="fas fa-money-bill-wave"></i> 支出</h3>
                <div class="text_input_money red">{{ $ecategory_day_allsum }}円</div>
            </div>   
            <div class="col-lg-4 text-center">
                <h3 class="text_input_text"><i class="fas fa-wallet"></i> 合計</h3>
                <div class="text_input_money">{{ $icategory_day_allsum - $ecategory_day_allsum }}円</div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-6 text-center">
                <h3 class="text_input_text"><i class="fas fa-credit-card"></i> 持越</h3>
                <div class="text_input_money">{{$carryover1}}円</div>
            </div>
            <div class="col-lg-6 text-center">
                <h3 class="text_input_text"><i class="fas fa-money-check"></i> 残高</h3>
                <div class="text_input_money">{{$icategory_day_allsum - $ecategory_day_allsum + $carryover1}}円</div>
            </div>
        </div>
        
        <div class="row ">
            <div class="col-lg-6 ">
                <div class="col-lg-12 ">
                    <h3 class="col-lg-12 text-center text_income"><i class="fas fa-money-bill"></i> 収入</h3>
                </div>
                <div class="col-lg-10 col-md-8 col-sm-8 col-xs-8 text_report mx-auto">
                    <div style="width: 100%">
                        <canvas class="chart-width" id="i-pie-chart" height="350"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="col-lg-12 ">
                    <h3 class="col-lg-12 text-center text_income"><i class="fas fa-money-bill-wave"></i> 支出</h3>
                </div>
                <div class="col-lg-10 col-md-8 col-sm-8 col-xs-8 text_report mx-auto">
                    <div style="width: 100%">
                         <canvas class="chart-width" id="e-pie-chart" height="350"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <h3 class="col-lg-12 text-center text_income"><i class="fas fa-money-bill"></i> 収入</h3>
                @foreach($icastsums as $icastsum)
                    <div class="row list_report">
                        <li class="col-lg-3">{{ ($icastsum[0]) }}</li>
                        <li class="col-lg-6 text-right blue">{{ ($icastsum[1]) }}円</li>
                        <li class="col-lg-3 text-right">{{ round(($icastsum[1]) / $icategory_day_allsum * 100, 1) }}%</li>
                    </div>     
                @endforeach
            </div>
            <div class="col-lg-6">
                <h3 class="col-lg-12 text-center text_expenditure"><i class="fas fa-money-bill-wave"></i> 支出</h3>
                @foreach($ecastsums as $ecastsum)
                    <div class="row list_report">
                        <li class="col-lg-3">{{ ($ecastsum[0]) }}</li>
                        <li class="col-lg-6 text-right red">{{ ($ecastsum[1]) }}円</li>
                        <li class="col-lg-3 text-right">{{ round(($ecastsum[1]) / $ecategory_day_allsum * 100, 1) }}%</li>
                    </div>     
                @endforeach
            </div>
        </div>
    </div

<div style="width: 50%"></div>
<script>
    var ivalue = JSON.parse('<?php echo $ivalue?>');
    var icolor = JSON.parse('<?php echo $icolor?>');
    var ihighlight = JSON.parse('<?php echo $ihighlight?>');
    var ilabel = JSON.parse('<?php echo $ilabel?>');
    
    var evalue = JSON.parse('<?php echo $evalue?>');
    var ecolor = JSON.parse('<?php echo $ecolor?>');
    var ehighlight = JSON.parse('<?php echo $ehighlight?>');
    var elabel = JSON.parse('<?php echo $elabel?>');

    var iPieData = [];
    if(ivalue.length > 0){
        for (var i=0; i<ivalue.length; i++){
            iPieData.push({
                value: ivalue[i][1],
                color: icolor[i][0],
                highlight: ihighlight[i][0],
                label: ilabel[i][0] 
            });
        }
    }else{
        iPieData.push({
            value: 1,
            color: "#D3D3D3",
            highlight: "#DCDCDC",
            label: "なし" 
        });
    }
    
    var ePieData = [];
    if(evalue.length > 0){
        for (var i=0; i<evalue.length; i++){
            ePieData.push({
                value: evalue[i][1],
                color: ecolor[i][0],
                highlight: ehighlight[i][0],
                label: elabel[i][0] 
            });
        }
    }else{
        ePieData.push({
            value: 1,
            color: "#D3D3D3",
            highlight: "#DCDCDC",
            label: "なし" 
        });
    }

    window.onload = function(){
        var ictx = document.getElementById("i-pie-chart").getContext("2d");
        window.iMyPie = new Chart(ictx).Doughnut(iPieData,{responsive : true});
        
        var ectx = document.getElementById("e-pie-chart").getContext("2d");
        window.eMyPie = new Chart(ectx).Doughnut(ePieData,{responsive : true});
    };
</script>

@endsection

