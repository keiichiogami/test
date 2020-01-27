<?php
namespace App\Http\Controllers\Input;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Income;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function add(Request $request)
    {
        
        $week = array("(日)", "(月)", "(火)", "(水)", "(木)", "(金)", "(土)");
        $w = date('w');
        
        $date = $request->date;
        if($date==NULL){
            $date=date('Y/n/j');
        }
        $categorys_i = \DB::table('categorys_i')->get(); 
        
        return view('input.income.create_income',['date'=>$date,'categorys_i'=>$categorys_i]);
    }
    
    public function create(Request $request)
    {
        $this->validate($request, Income::$rules);
        $income = new Income;
        $form = $request->all();
    
        $income->user_id = Auth::id();
        $income->date = explode("(", $request->date)[0];
        
        unset($form['_token']);
        unset($form['date']);
        $income->fill($form);
        $income->save();
        
        return redirect ('calendar');
    }
    
    public function edit()
    {
        return view('input.edit');
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
