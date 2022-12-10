<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
        'app_id',
        'city',
        'image',
        'business',
        'contact',
        'sms_otp',
        'contact_verify',
        'plan_start',
        'plan_end',
    ];

    protected $appends = ['image_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token','device','device_id','api_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $languages = [
        'Gujarati'=> 'Gujarati',
        'Hindi' => 'Hindi',
        'English' => 'English'
    ];

     
    public function getImageUrlAttribute($value)
    {
        if ($this->image) {
            return asset('storage/profile-images/'.$this->image);
        }
        else null;

        // return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url('storage/profile-images/'.$this->attributes['image']):null;
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

}
