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
        $target_month = new Carbon($ym . '-01');
        $start_of_month = $target_month->copy()->startOfMonth();
        $end_of_month = $target_month->copy()->endOfMonth();
        
        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            $day_sum = $income::where('date',$date->format('Y/m/d'))->sum('money');
            $day_sums[] = $day_sum;
            $dates[] = $date->copy();
            if($date->gte($start_of_month) && $date->lte($end_of_month)){
               $month_sum += $day_sum; 
            }
        }
        
        return view('calendar', ['today' => $today, 'currentMonth' => $currentMonth, 'week'=>$week, 'prev' => $prev, 
                    'next'=>$next, 'html_title' => $html_title, 'dates' => $dates, 'income' => $income, 'incomes' => $incomes, 
                    'ym' => $ym, 'categorys_i' => $categorys_i, 'money' =>$money, 'day_sums' => $day_sums, 'month_sum' => $month_sum
                ]);
    }
}