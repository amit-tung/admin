<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FestivalPost extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'festival_category_id','festival_sub_category_id','festival_peta_category_id','title','media','media_type' ,'status','description','language','app_id',
    ];
    protected $appends = ['media_url'];

    public function festival_category(){
        return $this->belongsTo(FestivalCategory::class,'festival_category_id','id');
    }
    public function festivalSubCategory(){
        return $this->belongsTo(FestivalSubCategory::class,'festival_sub_category_id','id');
    }
    public function festivalPetaCategory(){
        return $this->belongsTo(FestivalPetaCategory::class,'festival_peta_category_id','id');
    }

    public function getMediaUrlAttribute($value)
    {
        if ($this->media) {
            return asset('storage/festival-'.$this->media_type.'/'.$this->media);
        }
        else null;
    }
}
