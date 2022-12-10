<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DharmaImage extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'dharma_image_category_id','language','title','image' ,'status','description',
    ];
    protected $appends = ['image_url'];
   protected $table = 'dharma_images';

    public function dharma_image_category(){
        return $this->belongsTo(DharmaImageCategory::class,'dharma_image_category_id','id');
    }

    public function getImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
    }

}