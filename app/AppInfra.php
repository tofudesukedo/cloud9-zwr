<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppInfra extends Model
{
    Public function Srv()
  {
      return $this->belongsTo('App\Srv');
  }
  
  Public function Domain()
  {
      return $this->belongsTo('App\Domain');
  }
}
