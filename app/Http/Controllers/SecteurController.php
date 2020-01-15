<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Secteur;

class SecteurController extends Controller
{
     //Load all secteurs

    public function LoadSecteurs(){

    	try {

    		$secteurs = Secteur::all();

    		return $data =[
    			 'secteurs'=> $secteurs,
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
