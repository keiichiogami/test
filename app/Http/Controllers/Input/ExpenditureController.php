<?php

namespace App\Http\Controllers\Input;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public function add(Request $request)
    {
        $week = array("(日)", "(月)", "(火)", "(水)", "(木)", "(金)", "(土)");
        $w = date('w');
        
        $date = $request->date;
        if($date==NULL){
            $date=date('Y-n-j'.$week[$w]);
        }
        return view('input.expenditure.create_expenditure',['date'=>$date]);
    }
    
    public function create()
    {
        return redirect ('calendar');
    }
    
    public function edit()
    {
        return view('input.expenditure.create_expenditure');
    }
    
    public function update()
    {
        return redirect ('calendar');
    }
    
    public function delete()
    {
        return redirect ('calendar');
    }
}