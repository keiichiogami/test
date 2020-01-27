<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenditureReportController extends Controller
{
    public function month()
    {
        return view('report.expenditure.month_expenditure');
    }
    
    public function year()
    {
        return view('report.expenditure.year_expenditure');
    }
}