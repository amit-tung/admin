<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BusinessPost extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'business_category_id','language','title','media' ,'status','description','media_type','app_id',
    ];
    protected $appends = ['media_url'];

    public function business_category(){
        return $this->belongsTo(BusinessCategory::class,'business_category_id','id');
    }

    public function getMediaUrlAttribute($value)
    {
        if ($this->media) {
            return asset('storage/business-'.$this->media_type.'/'.$this->media);
        }
    }

}
