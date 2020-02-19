<?php
namespace App\Http\Controllers\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Category;
use App\Ecategory;
use App\Expenditure;
use App\User;

class ExpenditureController extends Controller
{
    public function add(Request $request)
    {
        //日付を取得する
        $date = $request->date;
        
        //日付のデータがない場合、当日の日付を取得
        if($date == NULL){
            $date = date('Y/m/d');
        }
        
        //支出のカテゴリーモデル
        $ecategories = Ecategory::all(); 
        
        return view('input.expenditure.create_expenditure', ['date' => $date, 'ecategories' => $ecategories]);
    }
    
    public function create(Request $request)
    {
        //バリデーション
        $this->validate($request, Expenditure::$rules);
        
        //リクエストで受け取る
        $form = $request->all();
        
        //ユーザーのidをモデルのuser_idに渡す
        $expenditure = new Expenditure;
        $expenditure->user_id = Auth::id();
        
        //tokenを削除
        unset($form['_token']);
        
        //データをfillで渡し保存する
        $expenditure->fill($form);
        $expenditure->save();
        
        return redirect ('calendar');
    }
    
    public function edit(Request $request)
    {
        //支出のカテゴリーモデル
        $ecategories = Ecategory::all(); 
        
        //findでidを関連付けする
        $expenditure = Expenditure::find($request->id);
        
        return view('input.expenditure.edit_expenditure', ['ecategories' => $ecategories, 'expenditure' => $expenditure]);
    }
    
    public function update(Request $request)
    {
        //バリデーション
        $this->validate($request, Expenditure::$rules);
        
        //ユーザーのidをモデルのuser_idに渡す
        $expenditure = Expenditure::find($request->id);
        
        //リクエストで受け取る
        $form = $request->all();
        
        //ユーザーのidをモデルのuser_idに渡す
        $expenditure->user_id = Auth::id();
        
        //tokenを削除
        unset($form['_token']);
        
        //データをfillで渡し保存する
        $expenditure->fill($form)->save();
        
        return redirect ('calendar');
    }
    
    public function delete(Request $request)
    {
        //ユーザーのidをモデルのuser_idに渡す
        $expenditure = Expenditure::find($request->id);
        
        //モデルのデータを削除する
        $expenditure->delete();
        
        return redirect ('calendar');
    }
    
    public function category_add(Request $request)
    {
        //支出のカテゴリーモデル
        $ecategories = Ecategory::all();
        
        return view('input.expenditure.category_expenditure', ['ecategories' => $ecategories]);
    }
    
    public function category_create(Request $request)
    {
        //バリデーション
        $this->validate($request, Ecategory::$rules);
        
        //リクエストで受け取る
        $form = $request->all();
        $ecategory = new Ecategory;
        
        //tokenを削除
        unset($form['_token']);
        
        //データをfillで渡し保存する
        $ecategory->fill($form);
        $ecategory->save();
        
        return redirect ('input/expenditure/create');
    }
    
    public function category_delete(Request $request)
    {
        //ユーザーのidをモデルのuser_idに渡す
        $ecategory = Ecategory::find($request->id);
        
        //モデルのデータを削除する
        $ecategory->delete();
        
        //category_idとリクエストから受け取ったidが一致した場合
        $null_category = Expenditure::where('category_id', $request->id)->get();
        
        //カテゴリーが削除されて既にデータが入っていた場合category_idを1にして保存
        foreach($null_category as $item){
            $item->category_id = 1;
            $item->save();
        }
        
        return redirect ('input/expenditure/category_create');
    }
}