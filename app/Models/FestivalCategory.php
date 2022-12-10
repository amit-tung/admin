<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FestivalCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sequence','name','image' ,'status','language','active_from','festival_date','display_order'
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        if ($this->image) {
            return asset('storage/festival-image-category/'.$this->image);
        }
        else null;
    }
    public function apps()
    {
        return $this->belongsToMany(App::class,'app_category_festivals');
    }

    // protected static function boot() {
    //     parent::boot();
    //     static::deleted(function($category) {
    //        $category->festival_images()->delete();
    //        $category->festival_videos()->delete();
    //     });
    // }

    

}
