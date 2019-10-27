<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    //
    protected $fillable = [
        'user_id', 'shop_id', 'visiting_time', 'message', 'seen',
    ];

    public static function hasVisitedShop($shop_id)
    {
        $query = self::where('shop_id', $shop_id);
        if ($query->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function hasUserVisitedShop($user_id)
    {
        $query = self::where('user_id', $user_id);
        if ($query->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function hasVisits()
    {
        $query = self::select();
        if ($query->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
