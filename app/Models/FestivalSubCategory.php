<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FestivalSubCategory extends Model
{

    protected $fillable = [
        'festival_category_id','sequence','name','image' ,'status','language','active_from','festival_date','display_order'
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        if ($this->image) {
            return asset('storage/festival-sub-category/'.$this->image);
        }
        else null;
    }
    public function festivalCategory()
    {
        return $this->belongsTo(FestivalCategory::class);
    }
    public function apps()
    {
        return $this->belongsToMany(App::class,'app_sub_category_festivals');
    }
}
