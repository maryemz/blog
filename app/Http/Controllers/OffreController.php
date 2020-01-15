<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offre;
use Auth;

class OffreController extends Controller
{
	//Chargement de toutes les  offres publiées

    public function LoadPublishedOffres(){

    	try{

    		$offres = Offre::where('is_published',1)->with('user')->with('publisher')->with('secteur')->paginate(5);
    		
    		return $data =[
	    			     'offres' => $offres,
	    		         'etat' => 1
    		          ];

    	}catch(Exception $e){
    		 return $data =[
	    			  'error' => $e->getMessage(),
	    		      'etat' => 0
    		        ];
              
    	}
    }
     //Create new offre

    public function store(Request $request) {

    	try {
            $rules = [
                'title' => 'required',
                'text' => 'required',
                'secteur' => 'required',
            ];

            $customMessages = [
                'title.required' => 'Le champ titre est obligatoire.',
                'text.required'  => 'Le contenu de votre offre est obligatoire.',
                'secteur.required' => "Veuillez choisir un secteur d'activité.",

            ];

            $this->validate($request, $rules, $customMessages);
            $offre = new Offre();
    		$offre->Title = $request->title;
    		$offre->Text = $request->text;
    		$offre->user_id = Auth::user()->id;
            $offre->secteur_id = $request->secteur;
               //if user choose save and publish  
            if($request->action == 1){
                $offre->is_published = 1;
                $offre->published_by = Auth::user()->id;
            }
                 
    		$offre->save();
        
    		return $data =[
	    			  'offre' =>$offre,
	    		      'etat' => 1
    		        ];
    		
    	} catch (Exception $e) {
    		return $data =[
	    			  'error' => $e->getMessage(),
	    		      'etat' => 0
    		        ];
    		
    	}
    }
    //Update offre
    public function update($id,Request $request) {

        try {
            $rules = [
                'title' => 'required',
                'text' => 'required',
                'secteur' => 'required',
            ];

            $customMessages = [

                'title.required' => 'Le champ titre est obligatoire.',
                'text.required'  => 'Le contenu de votre post est obligatoire.',
                'secteur.required' => "Veuillez choisir un secteur d'activité.",

            ];
            $this->validate($request, $rules, $customMessages);
            $offre = Offre::find($id);
            $offre->Title = $request->title;
            $offre->Text = $request->text;
            $offre->secteur_id = $request->secteur;
            $offre->save();
          
            
        } catch (Exception $e) {

            return $data =[
                      'error' => $e->getMessage(),
                      'etat' => 0
                    ];
            
        }


    }
  //suppression d'une offre
  public function destroy($id){

    try {

         $offre = Offre::find($id);
         $offre->delete();
        
    } catch (Exception $e) {
        return $data =[
                      'error' => $e->getMessage(),
                      'etat' => false,
                    ];
    }

   
  }

   //Filtre offres
  public function filterOffre(Request $request) {
    try {
            $offres = Offre::when($request->title , function ($query) use ($request) {
                             $query->where('title','LIKE','%'.$request->title.'%');
                        })->when($request->secteur,function($query) use ($request) {
                              $query->where('secteur_id',$request->secteur);
                    
             })->where('is_published',1)
              ->with('user')
              ->with('publisher')
              ->with('secteur')
              ->paginate(5);  
            return $data =[
                         'offres' => $offres,
                         'etat' => 1
                      ];

        }catch(Exception $e){
             return $data =[
                      'error' => $e->getMessage(),
                      'etat' => 0
                    ];
              
        }
  } 
  //Load all my offres

    public function LoadMyOffres(){

      try{

        $offres = Auth::user()->offres()->with('user')->with('publisher')->with('secteur')->paginate(5);
        
        return $data =[
                 'offres' => $offres,
                   'etat' => 1
                  ];

      }catch(Exception $e){
         return $data =[
              'error' => $e->getMessage(),
                'etat' => 0
                ];
              
      }
    } 

}
