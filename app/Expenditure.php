<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    protected $guarded = array('id');
    
    public static $rules = array(
        'date' => 'required|date_format:"Y/m/d"',
        'money' => 'required',
        'category_id' => 'required',
    );
}
