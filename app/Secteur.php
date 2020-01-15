<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
     public function offres(){
        
        return $this->hasMany('App\Offre');
    }
}
