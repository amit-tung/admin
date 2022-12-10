<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DharmaVideoCategory extends Model
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
    public function dharma_images(){
        return $this->hasMany('App\Model\DharmaImage','dharma_image_category_id');
    }
    public function dharma_videos(){
        return $this->hasMany('App\Model\DharmaVideo','dharma_video_category_id');
    }

    protected static function boot() {
        parent::boot();
        static::deleted(function($dharma_category) {
            $dharma_category->dharma_images()->delete();
            $dharma_category->dharma_videos()->delete();
        });
    }

}
