<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BusinessVideoCategory extends Model
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
    public function business_images(){
        return $this->hasMany('App\Model\BusinessImage','business_image_category_id');
    }
    public function business_videos(){
        return $this->hasMany('App\Model\BusinessVideo','business_video_category_id');
    }

    protected static function boot() {
        parent::boot();
        static::deleted(function($business_category) {
            $business_category->business_images()->delete();
            $business_category->business_videos()->delete();
        });
    }

}
