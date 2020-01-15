<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public function posts(){

   		return $this->belongsToMany('App\Post','post_categorie');
   }
}
