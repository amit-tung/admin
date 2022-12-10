<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UserBusinessProfile extends Model
{

    protected $fillable = [
        'user_id','business_name','logo' ,'email','number_1','number_2','web_site','address','business_category_id'
    ];
    protected $appends = ['logo_url'];

    public function business_video_category(){
        return $this->belongsTo(BusinessVideoCategory::class,'business_video_category_id','id');
    }

    public function getLogoUrlAttribute($value)
    {
        return  !empty($this->attributes['logo']) && Storage::exists($this->attributes['logo'])? Storage::url($this->attributes['logo']):null;
    }

}
