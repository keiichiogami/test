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
});

Route::group(['prefix' => 'input/expenditure', 'middleware' => 'auth'], function() {
    Route::get('create', 'Input\ExpenditureController@add');	
    Route::post('create', 'Input\ExpenditureController@create');
    Route::get('edit', 'Input\ExpenditureController@edit');
    Route::post('edit', 'Input\ExpenditureController@update');
    Route::get('delete', 'Input\ExpenditureController@delete');
});

Route::group(['prefix' => 'report/income', 'middleware' => 'auth'], function() {
    Route::get('month_income', 'Report\IncomeReportController@month');
    Route::get('year_income', 'Report\IncomeReportController@year');
});
 
Route::group(['prefix' => 'report/expenditure', 'middleware' => 'auth'], function() {   
    Route::get('month_expenditure', 'Report\ExpenditureReportController@month');
    Route::get('year_expenditure', 'Report\ExpenditureReportController@year');
});

 Route::get('test', 'Test1Controller@add');	

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/calendar', 'HomeController@index')->middleware('auth');