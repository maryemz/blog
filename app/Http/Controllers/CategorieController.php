<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;

class CategorieController extends Controller
{
    //Load all actegories

    public function LoadCategories(){

    	try {

    		$categories = Categorie::all();

    		return $data =[
    			 'categories'=> $categories,
    			 'etat' => true,
    		];

    		
    	}catch (Exception $e) {

    		return $data =[
	    			  'error' => $e->getMessage(),
	    		      'etat' => false,
    		        ];
    		
    	}
    }
}
