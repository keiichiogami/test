<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function add()
    {
        return view('input.expenditure.create_expenditure');
    }
}
