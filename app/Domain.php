<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    Public function app_infra()
    {
        return $this->hasMany('App\AppInfra', 'domain_id');
    }
}
