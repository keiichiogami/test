<?php
namespace App\Http\Controllers\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Income;
use App\Icategory;
use App\User;

class IncomeController extends Controller
{
    public function add(Request $request)
    {
        //日付を取得する
        $date = $request->date;
        
        //日付のデータがない場合、当日の日付を取得
        if($date==NULL){
            $date=date('Y/m/d');
        }
        
        //収入のカテゴリーモデル
        $icategories = Icategory::all();
        
        return view('input.income.create_income', ['date' => $date, 'icategories' => $icategories]);
    }
    
    public function create(Request $request)
    {
        //バリデーション
        $this->validate($request, Income::$rules);
        
        //リクエストで受け取る
        $form = $request->all();
        
        //ユーザーのidをモデルのuser_idに渡す
        $income = new Income;
        $income->user_id = Auth::id();
        
        //tokenを削除
        unset($form['_token']);
        
        //データをfillで渡し保存する
        $income->fill($form);
        $income->save();
        
        return redirect ('calendar');
    }
    
    public function edit(Request $request)
    {
        //収入のカテゴリーモデル
        $icategories = Icategory::all(); 
        
        //findでidを関連付けする
        $income = Income::find($request->id);
        
        return view('input.income.edit_income', ['icategories' => $icategories, 'income' => $income]);
    }
    
    public function update(Request $request)
    {
        //バリデーション
        $this->validate($request, Income::$rules);
        
        //ユーザーのidをモデルのuser_idに渡す
        $income = Income::find($request->id);
        
        //リクエストで受け取る
        $form = $request->all();
        
        //ユーザーのidをモデルのuser_idに渡す
        $income->user_id = Auth::id();
        
        //tokenを削除
        unset($form['_token']);
        
        //データをfillで渡し保存する
        $income->fill($form)->save();
        
        return redirect ('calendar');
    }
    
    public function delete(Request $request)
    {
        //ユーザーのidをモデルのuser_idに渡す
        $income = Income::find($request->id);
        
        //モデルのデータを削除する
        $income->delete();
        
        return redirect ('calendar');
    }
    
    public function category_add(Request $request)
    {
        //収入のカテゴリーモデル
        $icategories = Icategory::all();
        
        return view('input.income.category_income', ['icategories' => $icategories]);
    }
    
    public function category_create(Request $request)
    {
        //バリデーション
        $this->validate($request, Icategory::$rules);
        
        //リクエストで受け取る
        $form = $request->all();
        $icategory = new Icategory;
        
        //tokenを削除
        unset($form['_token']);
        
        //データをfillで渡し保存する
        $icategory->fill($form);
        $icategory->save();
        
        return redirect ('input/income/create');
    }
    
    public function category_delete(Request $request)
    {
        //ユーザーのidをモデルのuser_idに渡す
        $icategory = Icategory::find($request->id);
        
        //モデルのデータを削除する
        $icategory->delete();
        
        //category_idとリクエストから受け取ったidが一致した場合
        $null_category = Income::where('category_id', $request->id)->get();
        
        //カテゴリーが削除されて既にデータが入っていた場合category_idを1にして保存
        foreach($null_category as $item){
            $item->category_id = 1;
            $item->save();
        }
        
        return redirect ('input/income/category_create');
    }
}