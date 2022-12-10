<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FestivalPetaCategory extends Model
{

    protected $fillable = [
        'festival_category_id','festival_sub_category_id','sequence','name','image' ,'status','language','active_from','festival_date','display_order'
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        if ($this->image) {
            return asset('storage/festival-peta-category/'.$this->image);
        }
        else null;
    }
    public function festivalSubCategory()
    {
        return $this->belongsTo(FestivalSubCategory::class);
    }
    public function festivalCategory()
    {
        return $this->belongsTo(FestivalCategory::class);
    }

    public function apps()
    {
        return $this->belongsToMany(App::class,'app_peta_category_festivals');
    }
}
