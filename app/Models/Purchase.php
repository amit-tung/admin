<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Purchase extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'user_id','plan_id' ,'company_id','amount','status','payment_data'
    ];

}
