<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UserFrame extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','image' ,'status',
    ];
    protected $appends = ['image_url','thumb_image_url'];
    protected $table = 'users_frames';

    public function getImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
    }

    public function getThumbImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists('thumb/'.$this->attributes['image'])? Storage::url('thumb/'.$this->attributes['image']):null;
    }

//    protected static function boot() {
//        parent::boot();
//        static::deleted(function($object) {
//            foreach ($object->subcategory as $record) {
//                $record->delete();
//            }
//        });
//    }

}
