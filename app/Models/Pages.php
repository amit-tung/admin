<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Pages extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'id','name','slug','status','detail'
    ];
//    protected $appends = ['image_url'];
     protected $table = 'pages';



//    public function getImageUrlAttribute($value)
//    {
//        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
//    }

}
