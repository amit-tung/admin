<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class GeneralVideo extends Model
{
    //

    //
    use SoftDeletes;

    protected $fillable = [
        'general_video_category_id','title','video' ,'status','description','language',
    ];
    protected $appends = ['video_url'];
    protected $table = 'general_videos';

    public function general_video_category(){
        return $this->belongsTo(GeneralVideoCategory::class,'general_video_category_id','id');
    }

    public function getVideoUrlAttribute($value)
    {
        return  !empty($this->attributes['video']) && Storage::exists($this->attributes['video'])? Storage::url($this->attributes['video']):null;
    }

}
