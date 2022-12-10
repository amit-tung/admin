<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    //

    //
    use SoftDeletes;

    protected $fillable = [
        'id','name','image' ,'status','link'
    ];
    protected $appends = ['image_url'];
    protected $table = 'slider';


    public function getImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
    }

//    public function getLinkUrlAttribute($value)
//    {
//        return  !empty($this->attributes['link']) && Storage::exists($this->attributes['link'])? Storage::url($this->attributes['link']):null;
//    }

}
