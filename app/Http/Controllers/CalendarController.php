<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Icategory;
use App\Income;
use App\Ecategory;
use App\Expenditure;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function add()
    {
        //今月の最初の日付
        $dt = Carbon::now()->startOfMonth();
        
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
        
        //当日  
        $today = Carbon::now()->format('Y/m/d');
        
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
                $income_month_sum += $income_day_sum; 
                $expenditure_month_sum += $expenditure_day_sum; 
                $input_month_sum = $income_month_sum - $expenditure_month_sum;
                $balance = $carryover + $input_month_sum;
            }
        }
        
        return view('calendar', ['ym' => $ym, 'html_title' => $html_title, 'today' => $today, 'currentMonth' => $currentMonth, 
            'prev1' => $prev1, 'prev2' => $prev2, 'prev3' => $prev3, 'next1' => $next1, 'next2' => $next2, 'next3' => $next3, 
            'dates' => $dates, 'icategories' => $icategories, 'income' => $income, 'incomes' => $incomes, 
            'income_day_sums' => $income_day_sums, 'income_month_sum' => $income_month_sum,'ecategories' => $ecategories, 'expenditure' => $expenditure, 
            'expenditures' => $expenditures,'expenditure_day_sums' => $expenditure_day_sums,'expenditure_month_sum' => $expenditure_month_sum, 
            'input_month_sum' => $input_month_sum, 'carryover' => $carryover, 'balance' => $balance,
            ]);
    }
}