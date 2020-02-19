<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Icategory;
use App\Income;
use App\Ecategory;
use App\Expenditure;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function month()
    {
        //今月の最初の日付
        $dt = Carbon::now('Asia/Tokyo')->startOfMonth();
        
        // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            $ym = $dt->format('Y-m');
        }
    
        // タイムスタンプを作成し、フォーマットをチェックする
        $timestamp = strtotime($ym . '-01');
        $dt->timestamp = $timestamp;
        if ($timestamp === false) {
            $ym = $dt->format('Y-m');
            $dt->timestamp = strtotime($ym . '-01');
        }

        //タイトル
        $html_title = $dt->format('Y年n月', $dt->timestamp);
        
        //今月
        $currentMonth = $dt->format('m');
        
        //先月（1ヵ月、2ヵ月、3ヵ月） 来月（1ヵ月、2ヵ月、3ヵ月）
        $prev1 = date('Y-m', strtotime('-1 month', $dt->timestamp));
        $next1 = date('Y-m', strtotime('+1 month', $dt->timestamp)); 
        $prev2 = date('Y-m', strtotime('-2 month', $dt->timestamp));
        $next2 = date('Y-m', strtotime('+2 month', $dt->timestamp));        
        $prev3 = date('Y-m', strtotime('-3 month', $dt->timestamp));
        $next3 = date('Y-m', strtotime('+3 month', $dt->timestamp));
        
        //月末が日曜日と月曜日の場合のバグを修正
        $addDay = ($dt->copy()->endOfMonth()->isSunday()) ? 7 : 0;
        if($dt->copy()->endOfMonth()->isMonday() && $dt->format('t') == '31'){
            $addDay = 7;
        }
        
        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $dt->subDay($dt->dayOfWeek);
        $count = 31 + $addDay + $dt->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];
        
        //incomeから受け取ったデータ
        $icategories = Icategory::all();
        $income = new Income;
        $incomes = Income::all();
        $income_day_sums = [];
        $income_month_sum = 0;
        
        //expenditureから受け取ったデータ
        $ecategories = Ecategory::all();
        $expenditure = new Expenditure;
        $expenditures = Expenditure::all();
        $expenditure_day_sums = [];
        $expenditure_month_sum = 0;
        
        //収入と支出を引いた額
        $input_month_sum = 0;
        
        //表示させる収支の範囲
        $target_month = new Carbon($ym . '-01');
        $start_of_month = $target_month->copy()->startOfMonth();
        $end_of_month = $target_month->copy()->endOfMonth();
        
        //持越金
        $prev_month = new Carbon($prev1);
        $end_of_prev_month = $prev_month->copy()->endOfMonth();
        $carryover_income_sum = Income::where('date', '<=', $end_of_prev_month)->sum('money');
        $carryover_expenditure_sum = Expenditure::where('date', '<=', $end_of_prev_month)->sum('money');
        $carryover = $carryover_income_sum - $carryover_expenditure_sum;
        
        //残高
        $balance = 0;
        
        //配列と合計の初期化
        $icastsums = [];
        $ecastsums = [];
        $icategory_day_allsum = 0;
        $ecategory_day_allsum = 0;
        
        $icategory_month_sum = 0;
        $ecategory_month_sum = 0;
        
        for ($i = 0; $i < $count; $i++, $dt->addDay()) {
            
            //日付を保存する copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $dt->copy();
            
            //収支を配列に保存
            $income_day_sum = $income::where('date',$dt->format('Y/m/d'))->sum('money');
            $income_day_sums[] = $income_day_sum;
            $expenditure_day_sum = $expenditure::where('date',$dt->format('Y/m/d'))->sum('money');
            $expenditure_day_sums[] = $expenditure_day_sum;
            
            //その月の初日から月末のデータを保存
            if($dt->gte($start_of_month) && $dt->lte($end_of_month)){
                
                //収支と残高
                $income_month_sum += $income_day_sum; 
                $expenditure_month_sum += $expenditure_day_sum; 
                $input_month_sum = $income_month_sum - $expenditure_month_sum;
                $balance = $carryover + $input_month_sum;
            }
        }
        
        //レポートのカテゴリーと収入の合計を配列に渡す
        foreach($icategories as $icategory){
            
            $icategory_day_sum = Income::where('date','like', date('%Y-m%', strtotime($ym)))->where('category_id',$icategory->id)->sum("money");
            $icategory_day_name = Income::where('date','like', date('%Y-m%', strtotime($ym)))->where('category_id',$icategory->id)->value("category_id");
            $icategory_day_allsum += $icategory_day_sum;   
            
            if($icategory_day_sum > 0){
                $icategory_month_sum = array($icategories[$icategory_day_name-1]->name,$icategory_day_sum);
                $icastsums[] = $icategory_month_sum; 
            }else{
                $icategory_month_sum = 0;
            }
        }
        
        //レポートのカテゴリーと支出の合計を配列に渡す
        foreach($ecategories as $ecategory){
            
            $ecategory_day_sum = Expenditure::where('date','like', date('%Y-m%', strtotime($ym)))->where('category_id',$ecategory->id)->sum("money");
            $ecategory_day_name = Expenditure::where('date','like', date('%Y-m%', strtotime($ym)))->where('category_id',$ecategory->id)->value("category_id");
            $ecategory_day_allsum += $ecategory_day_sum;   
            
            if($ecategory_day_sum > 0){
                $ecategory_month_sum = array($ecategories[$ecategory_day_name-1]->name,$ecategory_day_sum);
                $ecastsums[] = $ecategory_month_sum; 
            }else{
                $ecategory_month_sum = 0;
            }
        }
        
        //円グラフのカラー
        $icolors = [];
        $ihighlights = [];
        
        $icolors = [["#222222"],["#000022"],["#555555"],["#000055"],["#999999"],
                    ["#000088"],["#DDDDDD"],["#222222"],["#000022"],["#555555"],
                    ["#000055"],["#999999"],["#000088"],["#DDDDDD"],["#222222"],
                    ["#000022"],["#555555"],["#000055"],["#999999"],["#000088"],["#DDDDDD"]];
                    
        $ihighlights = [["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"]];
        
        $ecolors = [];
        $ehighlights = [];
        
        $ecolors = [["#222222"],["#000022"],["#555555"],["#000055"],["#999999"],
                    ["#000088"],["#DDDDDD"],["#222222"],["#000022"],["#555555"],
                    ["#000055"],["#999999"],["#000088"],["#DDDDDD"],["#222222"],
                    ["#000022"],["#555555"],["#000055"],["#999999"],["#000088"],["#DDDDDD"]];
                    
        $ehighlights = [["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"]];
        
        //円グラフのjavascriptに渡すデータ
        $ivalue = $varJsSample=json_encode($icastsums , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $icolor = $varJsSample=json_encode($icolors , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $ihighlight = $varJsSample=json_encode($ihighlights , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $ilabel = $varJsSample=json_encode($icastsums , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        
        $evalue = $varJsSample=json_encode($ecastsums , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $ecolor = $varJsSample=json_encode($ecolors , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $ehighlight = $varJsSample=json_encode($ehighlights , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $elabel = $varJsSample=json_encode($ecastsums , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        
        return view('report.month_report', ['ym' => $ym, 'html_title' => $html_title,  'currentMonth' => $currentMonth, 
            'prev1' => $prev1, 'prev2' => $prev2, 'prev3' => $prev3, 'next1' => $next1, 'next2' => $next2, 'next3' => $next3, 
            'dates' => $dates, 'icategories' => $icategories, 'income' => $income, 'incomes' => $incomes, 
            'income_day_sums' => $income_day_sums, 'income_month_sum' => $income_month_sum,
            'ecategories' => $ecategories, 'expenditure' => $expenditure, 'expenditures' => $expenditures,
            'expenditure_day_sums' => $expenditure_day_sums,'expenditure_month_sum' => $expenditure_month_sum, 
            'input_month_sum' => $input_month_sum, 'carryover' => $carryover,'balance' => $balance, 
            'icategory_month_sum' => $icategory_month_sum, 'icastsums' => $icastsums, 'ecastsums' => $ecastsums,
            'icategory_day_sum' => $icategory_day_sum,
            'icategory_day_allsum' => $icategory_day_allsum, 'ecategory_day_allsum' => $ecategory_day_allsum,
            'icolors' => $icolors, 'ihighlights' => $ihighlights, 'ecolors' => $ecolors, 'ehighlights' => $ehighlights,
            'ivalue' => $ivalue, 'icolor' => $icolor, 'ihighlight' => $ihighlight, 'ilabel' => $ilabel,
            'evalue' => $evalue, 'ecolor' => $ecolor, 'ehighlight' => $ehighlight, 'elabel' => $elabel
            ]);
    }
    
    public function year()
    {
        //今月の最初の日付
        $dt = Carbon::now('Asia/Tokyo')->startOfMonth();
        
        // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            $ym = $dt->format('Y');
        }
        
        // タイムスタンプを作成し、フォーマットをチェックする
        $timestamp = strtotime($ym);
        $dt->timestamp = $timestamp;
        if ($timestamp === false) {
            $ym = $dt->format('Y');
            $dt->timestamp = strtotime($ym);
        }
        
        //タイトル
        $html_title = $dt->format('Y年', $dt->timestamp);
        
        //今月
        $currentMonth = $dt->format('m');
        
        //先月（1ヵ月、2ヵ月、3ヵ月） 来月（1ヵ月、2ヵ月、3ヵ月）
        $prev1 = date('Y-m', strtotime('-1 year', $dt->timestamp));
        $next1 = date('Y-m', strtotime('+1 year', $dt->timestamp)); 
        $prev2 = date('Y-m', strtotime('-2 year', $dt->timestamp));
        $next2 = date('Y-m', strtotime('+2 year', $dt->timestamp));        
        $prev3 = date('Y-m', strtotime('-3 year', $dt->timestamp));
        $next3 = date('Y-m', strtotime('+3 year', $dt->timestamp));
        
        //月末が日曜日と月曜日の場合のバグを修正
        $addDay = ($dt->copy()->endOfMonth()->isSunday()) ? 7 : 0;
        if($dt->copy()->endOfMonth()->isMonday() && $dt->format('t') == '31'){
            $addDay = 7;
        }
        
        // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
        $dt->subDay($dt->dayOfWeek);
        $count = 31 + $addDay + $dt->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];
        
        //incomeから受け取ったデータ
        $icategories = Icategory::all();
        $income = new Income;
        $incomes = Income::all();
        $income_day_sums = [];
        $income_month_sum = 0;
        
        //expenditureから受け取ったデータ
        $ecategories = Ecategory::all();
        $expenditure = new Expenditure;
        $expenditures = Expenditure::all();
        $expenditure_day_sums = [];
        $expenditure_month_sum = 0;
        
        //収入と支出を引いた額
        $input_month_sum = 0;
        
        //表示させる収支の範囲
        $target_month = new Carbon($ym . '-01');
        $start_of_month = $target_month->copy()->startOfMonth();
        $end_of_month = $target_month->copy()->endOfMonth();
        
        //持越金
        $prev_month = new Carbon($prev1);
        $end_of_prev_month = $prev_month->copy()->endOfMonth();
        $carryover_income_sum = Income::where('date', '<=', $end_of_prev_month)->sum('money');
        $carryover_expenditure_sum = Expenditure::where('date', '<=', $end_of_prev_month)->sum('money');
        $carryover = $carryover_income_sum - $carryover_expenditure_sum;
        
        //持越金　年
        $prev_year1 = new Carbon($prev1);
        $end_of_prev_year1 = $prev_year1->copy()->endOfyear();
        $carryover_income_sum1 = Income::where('date', '<=', $end_of_prev_year1)->sum('money');
        $carryover_expenditure_sum1 = Expenditure::where('date', '<=', $end_of_prev_year1)->sum('money');
        $carryover1 = $carryover_income_sum1 - $carryover_expenditure_sum1;
        
        //残高
        $balance = 0;
        
        //配列と合計の初期化
        $icastsums = [];
        $ecastsums = [];
        $icategory_day_allsum = 0;
        $ecategory_day_allsum = 0;
        
        for ($i = 0; $i < $count; $i++, $dt->addDay()) {
            
            //日付を保存する copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $dt->copy();
            
            //収支を配列に保存
            $income_day_sum = $income::where('date',$dt->format('Y/m/d'))->sum('money');
            $income_day_sums[] = $income_day_sum;
            $expenditure_day_sum = $expenditure::where('date',$dt->format('Y/m/d'))->sum('money');
            $expenditure_day_sums[] = $expenditure_day_sum;
            
            //その月の初日から月末のデータを保存
            if($dt->gte($start_of_month) && $dt->lte($end_of_month)){
                
                //収支と残高
                $income_month_sum += $income_day_sum; 
                $expenditure_month_sum += $expenditure_day_sum; 
                $input_month_sum = $income_month_sum - $expenditure_month_sum;
                $balance = $carryover + $input_month_sum;
            }
        }
        
        //レポートのカテゴリーと収入の合計を配列に渡す
        foreach($icategories as $icategory){
            
            $icategory_day_sum = Income::where('date','like', date('%Y%', strtotime($ym)))->where('category_id',$icategory->id)->sum("money");
            $icategory_day_name = Income::where('date','like', date('%Y%', strtotime($ym)))->where('category_id',$icategory->id)->value("category_id");
            $icategory_day_allsum += $icategory_day_sum;   
            
            if($icategory_day_sum > 0){
                $icategory_month_sum = array($icategories[$icategory_day_name-1]->name,$icategory_day_sum);
                $icastsums[] = $icategory_month_sum; 
            }else{
                $icategory_month_sum = 0;
            }
        }
        
        //レポートのカテゴリーと支出の合計を配列に渡す
        foreach($ecategories as $ecategory){
            
            $ecategory_day_sum = Expenditure::where('date','like', date('%Y%', strtotime($ym)))->where('category_id',$ecategory->id)->sum("money");
            $ecategory_day_name = Expenditure::where('date','like', date('%Y%', strtotime($ym)))->where('category_id',$ecategory->id)->value("category_id");
            $ecategory_day_allsum += $ecategory_day_sum;   
            
            if($ecategory_day_sum > 0){
                $ecategory_month_sum = array($ecategories[$ecategory_day_name-1]->name,$ecategory_day_sum);
                $ecastsums[] = $ecategory_month_sum; 
            }else{
                $ecategory_month_sum = 0;
            }
        }
        
        //円グラフのカラー
        $icolors = [];
        $ihighlights = [];
        
        $icolors = [["#222222"],["#000022"],["#555555"],["#000055"],["#999999"],
                    ["#000088"],["#DDDDDD"],["#222222"],["#000022"],["#555555"],
                    ["#000055"],["#999999"],["#000088"],["#DDDDDD"],["#222222"],
                    ["#000022"],["#555555"],["#000055"],["#999999"],["#000088"],["#DDDDDD"]];
                    
        $ihighlights = [["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"]];
        
        $ecolors = [];
        $ehighlights = [];
        
        $ecolors = [["#222222"],["#000022"],["#555555"],["#000055"],["#999999"],
                    ["#000088"],["#DDDDDD"],["#222222"],["#000022"],["#555555"],
                    ["#000055"],["#999999"],["#000088"],["#DDDDDD"],["#222222"],
                    ["#000022"],["#555555"],["#000055"],["#999999"],["#000088"],["#DDDDDD"]];
                    
        $ehighlights = [["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],
                    ["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"],["#EEEEEE"]];
        
        //円グラフのjavascriptに渡すデータ
        $ivalue = $varJsSample=json_encode($icastsums , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $icolor = $varJsSample=json_encode($icolors , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $ihighlight = $varJsSample=json_encode($ihighlights , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $ilabel = $varJsSample=json_encode($icastsums , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        
        $evalue = $varJsSample=json_encode($ecastsums , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $ecolor = $varJsSample=json_encode($ecolors , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $ehighlight = $varJsSample=json_encode($ehighlights , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $elabel = $varJsSample=json_encode($ecastsums , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        
        return view('report.year_report', ['ym' => $ym, 'html_title' => $html_title, 'currentMonth' => $currentMonth, 
            'prev1' => $prev1, 'prev2' => $prev2, 'prev3' => $prev3, 'next1' => $next1, 'next2' => $next2, 'next3' => $next3,  
            'dates' => $dates, 'icategories' => $icategories, 'income' => $income, 'incomes' => $incomes, 
            'income_day_sums' => $income_day_sums, 'income_month_sum' => $income_month_sum,
            'ecategories' => $ecategories, 'expenditure' => $expenditure, 'expenditures' => $expenditures,
            'expenditure_day_sums' => $expenditure_day_sums, 'expenditure_month_sum' => $expenditure_month_sum, 
            'input_month_sum' => $input_month_sum, 'carryover' => $carryover, 'balance' => $balance, 
            'icategory_month_sum' => $icategory_month_sum, 'icastsums' => $icastsums, 'ecastsums' => $ecastsums,
            'icategory_day_sum' => $icategory_day_sum,
            'icategory_day_allsum' => $icategory_day_allsum, 'ecategory_day_allsum' => $ecategory_day_allsum,
            'icolors' => $icolors, 'ihighlights' => $ihighlights, 'ecolors' => $ecolors, 'ehighlights' => $ehighlights,
            'ivalue' => $ivalue, 'icolor' => $icolor, 'ihighlight' => $ihighlight, 'ilabel' => $ilabel,
            'evalue' => $evalue, 'ecolor' => $ecolor, 'ehighlight' => $ehighlight, 'elabel' => $elabel,
            'carryover1' => $carryover1
            ]);
    }
}