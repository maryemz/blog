<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    public function secteur(){

   		return $this->belongsTo('App\Secteur');
   }

    public function user(){

   		return $this->belongsTo('App\User');
   }

      public function publisher(){

   		return $this->belongsTo('App\User','published_by');
   }

}
