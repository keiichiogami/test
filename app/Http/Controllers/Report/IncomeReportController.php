<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeReportController extends Controller
{
    public function month()
    {
        return view('report.income.month_income');
    }
    
    public function year()
    {
        return view('report.income.year_income');
    }
}
