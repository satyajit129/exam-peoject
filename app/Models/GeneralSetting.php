<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $guarded = [];
    public static function getSetting()
    {
        return self::first(); // assuming only one row
    }
}
