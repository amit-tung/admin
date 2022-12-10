<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Plan extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'plan_image','payment_image' ,'contact','days','plan_amount'
    ];
    protected $appends = ['plan_image_url','payment_image_url'];
    protected $table = 'plan';

    public function getPlanImageUrlAttribute($value)
    {
        return  !empty($this->attributes['plan_image']) && Storage::exists($this->attributes['plan_image'])? Storage::url($this->attributes['plan_image']):null;
    }
    public function getPaymentImageUrlAttribute($value)
    {
        return  !empty($this->attributes['payment_image']) && Storage::exists($this->attributes['payment_image'])? Storage::url($this->attributes['payment_image']):null;
    }
}
