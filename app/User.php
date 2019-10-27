<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'phone_number', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        $this->api_token;
    }

    public function shops()
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }

    public function hasShop()
    {
        $expr = user()->shops();
        //dd($expr->count());
        if ($expr->count() > 0) {
            return true;
        }
        return false;
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function favorite_shops()
    {
        return $this->belongsToMany(Shop::class, 'favorite_shops', 'user_id', 'shop_id');
    }
}
