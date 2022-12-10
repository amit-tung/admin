<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class BusinessCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id','name','image' ,'status','language','app_id'
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        
        if ($this->image) {
            return asset('storage/business-category/'.$this->image);
        }
        else null;
    }
   
}
