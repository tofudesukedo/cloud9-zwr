<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Srv extends Model
{
    Public function app_infra()
    {
        return $this->hasMany('App\AppInfra', 'srv_id');
    }
}
