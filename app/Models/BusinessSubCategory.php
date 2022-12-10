<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BusinessSubCategory extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'business_category_id','name','image' ,'status','language','app_id'        
    ];

    protected $appends = ['image_url'];

    public function business_category(){
        return $this->belongsTo(BusinessCategory::class,'business_category_id','id');
    }

    public function getImageUrlAttribute($value)
    {
        if ($this->image) {
            return asset('storage/business-sub-category-images/'.$this->image);
        }
    }

}
