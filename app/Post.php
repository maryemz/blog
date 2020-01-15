<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   public function user(){

   		return $this->belongsTo('App\User');
   }
   public function publisher(){

   		return $this->belongsTo('App\User','published_by');
   }

    public function categories(){

   	   return $this->belongsToMany('App\Categorie','post_categorie');

   }
}
