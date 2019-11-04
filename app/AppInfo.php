<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model
{
    Public function app()
    {
        return $this->belongsTo('App\App');
    }
}
