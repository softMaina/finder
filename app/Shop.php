<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
    public $appends = ['favorited', 'available', 'visited'];
    //
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_shop', 'shop_id', 'user_id')->withTimestamps();
    }

    public static function hasShops()
    {
        $query = self::select();
        if ($query->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function shop_status()
    {
        return $this->belongsTo(ShopStatus::class, 'shop_status_id');
    }

    public function shop_images()
    {
        return $this->hasMany(ShopImage::class);
    }

    public function shop_size()
    {
        return $this->belongsTo(ShopSize::class);
    }

    public function shop_location()
    {
        return $this->belongsTo(ShopLocation::class);
    }

    public function isFavorited()
    {
        return (bool) FavoriteShop::where('user_id', Auth::id())
            ->where('shop_id', $this->id)
            ->first();
    }

    public function getFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getAvailableAttribute()
    {
        return $this->shop_status_id == 1 ? true : false;
    }

    public function getVisitedAttribute()
    {
        return true;
    }
}
