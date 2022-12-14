<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_token',
        'name', 
        'first_name',
        'last_name',
        'username',
        'status',
        'email', 
        'password',
        'device',
        'device_id',
        'gender',
        'country',
        'state',
        'taluka',
        'city',
        'image','business','contact','sms_otp','contact_verify','plan_start','plan_end',
    ];

    protected $appends = ['image_url'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','device','device_id','api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
    }
    /*
	public function getEmailAttribute($value)
    {
        return  "*****";
    }
    public function getContactAttribute($value)
    {
        return  "*****";
    } */


     public static $languages = [
         'Gujarati'=> 'Gujarati',
         'Hindi' => 'Hindi',
         'English' => 'English'
     ];
}
