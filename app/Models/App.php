<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{


    protected $fillable = [
        'route',
        'name',
        'package_id',
    ];


    public function festivalCategory()
    {
        return $this->belongsToMany(FestivalCategory::class,'app_category_festivals');
    }
    public function festivalSubCategory()
    {
        return $this->belongsToMany(FestivalSubCategory::class,'app_sub_category_festivals');
    }
    public function festivalPetaCategory()
    {
        return $this->belongsToMany(FestivalPetaCategory::class,'app_peta_category_festivals');
    }
    public function festivalPost()
    {
        return $this->belongsToMany(FestivalPost::class,'app_festival_posts');
    }

}
