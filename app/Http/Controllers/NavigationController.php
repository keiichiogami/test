<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function add()
    {
        //支出の入力画面を表示する
        return view('input.expenditure.create_expenditure');
    }
}
