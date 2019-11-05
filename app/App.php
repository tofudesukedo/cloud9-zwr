<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
   
   protected $fillable = [
        'name'
   ];
    
  Public function app_infra()
  {
      return $this->hasOne('App\AppInfra', 'app_id');
  }
  
}
