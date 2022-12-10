<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FestivalVideoCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sequence','name','image' ,'status','language','active_from','festival_date'
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
    }
    public function festival_images(){
        return $this->hasMany('App\Models\FestivalImage','general_image_category_id');
    }
    public function festival_videos(){
        return $this->hasMany('App\Models\FestivalVideo','general_video_category_id');
    }

    protected static function boot() {
        parent::boot();
        static::deleted(function($category) {
            $category->festival_images()->delete();
            $category->festival_videos()->delete();

        });
    }

}
