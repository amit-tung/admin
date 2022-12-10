<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class GeneralImageCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id','name','image' ,'status','language',
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
    }
    public function general_images(){
        return $this->hasMany('App\Model\GeneralImage','general_image_category_id');
    }
    public function general_videos(){
        return $this->hasMany('App\Model\GeneralVideo','general_video_category_id');
    }

    protected static function boot() {
        parent::boot();
        static::deleted(function($general_category) {
            $general_category->general_images()->delete();
            $general_category->general_videos()->delete();
        });
    }

}
