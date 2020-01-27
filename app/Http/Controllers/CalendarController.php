<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Income;
use App\Categorys_I;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function add()
    {
        $date = Carbon::now()->startOfMonth();

        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            $ym = $date->format('Y-m');
        }
        
        $timestamp = strtotime($ym . '-01');
        $date->timestamp = $timestamp;
        
        if ($timestamp === false) {
            $ym = date('Y-m');
            $date->timestamp = strtotime($ym . '-01');
        }
        
        $today = Carbon::now();
        $today = $today->format('Y/m/d');
        $currentMonth = $date->format('m');
        $week = array("(日)", "(月)", "(火)", "(水)", "(木)", "(金)", "(土)");
        
        $html_title = $date->format('Y年n月', $date->timestamp);
        
        $prev = date('Y-m', strtotime('-1 month', $date->timestamp));
        $next = date('Y-m', strtotime('+1 month', $date->timestamp));
        $addDay = ($date->copy()->endOfMonth()->isSunday()) ? 7 : 0;
        
        if($date->copy()->endOfMonth()->isMonday() && $date->format('t') == '31'){
            $addDay = 7;
        }
        
        $date->subDay($date->dayOfWeek);
        $count = 31 + $addDay + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;
        $dates = [];
        $day_sums = [];
        $categorys_i = \DB::table('categorys_i')->get();
        $income = new Income; //Income::where('date',$date)->value('money');
        
        $incomes = Income::all();
        $money = $income::all()->sum('money') - 11111111111500;
        
        $month_sum = 0;
        $end_of_month = $date->copy()->endOfMonth();
        
        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            $day_sum = $income::where('date',$date->format('Y/m/d'))->sum('money');
            $day_sums[] = $day_sum;
            $dates[] = $date->copy();
            if($date->lte($end_of_month)){
               $month_sum += $day_sum; 
            }
            
        }
        
        return view('calendar', ['today' => $today, 'currentMonth' => $currentMonth, 'week'=>$week, 'prev' => $prev, 
                    'next'=>$next, 'html_title' => $html_title, 'dates' => $dates, 'income' => $income, 'incomes' => $incomes, 
                    'ym' => $ym, 'categorys_i' => $categorys_i, 'money' =>$money, 'day_sums' => $day_sums, 'month_sum' => $month_sum]);
    }
    
    // function a($a){
        //     $income::where('date',$a)->sum('money');
        // }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // public function add(){
    //     $dt = Carbon::now('Asia/Tokyo');
        
    //     if(isset($_GET['yn'])){
    //         $yn = $_GET['yn'];
    //     }else{
    //         $yn =$dt->format('Y-n');
    //     }
        
    //     $timestamp = strtotime($yn . '-1');
    //     if($timestamp === false){
    //         $yn = $dt->format('Y-n');
    //         $timestamp = strtotime($yn . '-1'); 
    //     }
        
    //     $today = $dt->format('Y-n-j');
    //     $html_title = $dt->format('Y年n月', $timestamp);
        
    //     $prev = $dt->format('Y-n', strtotime('-1 month', $timestamp));
    //     $next = $dt->format('Y-n', strtotime('+1 month', $timestamp));
        
    //     $day_conunt = $dt->format('t', $timestamp);
    //     $youbi = $dt->format('w', $timestamp);
        
    //     $weeks = [];
    //     $week = '';
        
    //     $week = $week. str_repeat($youbi);
        
    //     return view('test',['yn' => $yn]);
    // }
}






// $dateStr = sprintf('2019-12');
//         $date = new Carbon($dateStr);
//         // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
//         $date->subDay($date->dayOfWeek);
//         // 同上。右下の隙間のための計算。
//         $count = 31 + $date->dayOfWeek;
//         $count = ceil($count / 7) * 7;
//         $dates = [];

//         for ($i = 0; $i < $count; $i++, $date->addDay()) {
//             // copyしないと全部同じオブジェクトを入れてしまうことになる
//             $dates[] = $date->copy();
//         }
//         //return $dates;
//         return view('test',['dates' => $dates]);




























// return view('test', ['dates' => $dates]);

// public function getCalendarDates($year, $month)
//     {
//         $date = new Carbon( time: "{$year}-{$month}-01");
//         $addDay = ($date->copy()->endOfMonth()->isSunday()) ? 7 : 0;
//         // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
//         $date->subDay($date->dayOfWeek);
//         // 同上。右下の隙間のための計算。
//         $count = 31 + $addDay + $date->dayOfWeek;
//         $count = ceil(value: $count / 7) * 7;
//         $dates = [];

//         for ($i = 0; $i < $count; $i++, $date->addDay()) {
//             // copyしないと全部同じオブジェクトを入れてしまうことになる
//             $dates[] = $date->copy();
//         }
//         return view('test', ['dates' => $dates]);
//     }


//  public function getCalendarDates($year, $month)
//     {
//         $dateStr = sprintf('%04d-%02d-01', $year, $month);
//         $date = new Carbon($dateStr);
//         // カレンダーを四角形にするため、前月となる左上の隙間用のデータを入れるためずらす
//         $date->subDay($date->dayOfWeek);
//         // 同上。右下の隙間のための計算。
//         $count = 31 + $date->dayOfWeek;
//         $count = ceil($count / 7) * 7;
//         $dates = [];

//         for ($i = 0; $i < $count; $i++, $date->addDay()) {
//             // copyしないと全部同じオブジェクトを入れてしまうことになる
//             $dates[] = $date->copy();
//         }
//         return view('test', ['dates' => $dates]);
//     }