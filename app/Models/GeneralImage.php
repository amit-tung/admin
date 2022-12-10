<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class GeneralImage extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'general_image_category_id','language','title','image' ,'status','description',
    ];
    protected $appends = ['image_url'];
     protected $table = 'general_images';

    public function general_image_category(){
        return $this->belongsTo(GeneralImageCategory::class,'general_image_category_id','id');
    }

    public function getImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
    }

}
