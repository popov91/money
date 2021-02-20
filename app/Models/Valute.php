<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valute extends Model
{
    public static function getListForUserSelect()
    {
        return self::get(['char_code', 'name']);
    }
}
