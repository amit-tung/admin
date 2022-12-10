<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ContactUs extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'contact' ,'email','website',
    ];

    protected $table = 'contactus';


}
