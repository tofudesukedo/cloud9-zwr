<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
   
  Public function app_infra() {
      return $this->hasMany('App\AppInfra', 'app_id');
  }
   
  Public function app_info() {
      return $this->hasMany('App\AppInfra', 'app_id');
  }
  
}
