<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DharmaVideo extends Model
{
    //

    //
    use SoftDeletes;

    protected $fillable = [
        'dharma_video_category_id','title','video' ,'status','description','language',
    ];
    protected $appends = ['video_url'];

    public function dharma_video_category(){
        return $this->belongsTo(DharmaVideoCategory::class,'dharma_video_category_id','id');
    }

    public function getVideoUrlAttribute($value)
    {
        return  !empty($this->attributes['video']) && Storage::exists($this->attributes['video'])? Storage::url($this->attributes['video']):null;
    }

}