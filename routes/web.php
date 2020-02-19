<?php

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('calendar', 'CalendarController@add');
});

Route::group(['prefix' => 'input/income', 'middleware' => 'auth'], function() {
    Route::get('create', 'Input\IncomeController@add');	
    Route::post('create', 'Input\IncomeController@create');
    Route::get('edit', 'Input\IncomeController@edit');
    Route::post('edit', 'Input\IncomeController@update');
    Route::get('delete', 'Input\IncomeController@delete');
    Route::get('category_create', 'Input\IncomeController@category_add');
    Route::post('category_create', 'Input\IncomeController@category_create');
    Route::get('category_delete', 'Input\IncomeController@category_delete');
});

Route::group(['prefix' => 'input/expenditure', 'middleware' => 'auth'], function() {
    Route::get('create', 'Input\ExpenditureController@add');	
    Route::post('create', 'Input\ExpenditureController@create');
    Route::get('edit', 'Input\ExpenditureController@edit');
    Route::post('edit', 'Input\ExpenditureController@update');
    Route::get('delete', 'Input\ExpenditureController@delete');
    Route::get('category_create', 'Input\ExpenditureController@category_add');
    Route::post('category_create', 'Input\ExpenditureController@category_create');
    Route::get('category_delete', 'Input\ExpenditureController@category_delete');    
});
 
Route::group(['prefix' => 'report', 'middleware' => 'auth'], function() {   
    Route::get('month_report', 'ReportController@month');
    Route::get('year_report', 'ReportController@year');
});

 Route::get('test', 'Test1Controller@add');	

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/calendar', 'HomeController@index')->middleware('auth');