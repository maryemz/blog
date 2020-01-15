<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use File;
class PostController extends Controller
{
    //Load all published posts

    public function LoadPublishedPosts(){

    	try{

    		$posts = Post::where('is_published',1)->with('user')->with('publisher')->with('categories')->paginate(9);
    		
    		return $data =[
	    			     'posts' => $posts,
	    		         'etat' => 1
    		          ];

    	}catch(Exception $e){
    		 return $data =[
	    			  'error' => $e->getMessage(),
	    		      'etat' => 0
    		        ];
              
    	}
    }

    //Create new post

    public function store(Request $request) {

    	try {
            $rules = [
                'title' => 'required',
                'text' => 'required',
                'categories' => 'required',
            ];

            $customMessages = [
                'title.required' => 'Le champ titre est obligatoire.',
                'text.required'  => 'Le contenu de votre post est obligatoire.',
                'categories.required' => 'Veuillez choisir une catégorie.',

            ];

            $this->validate($request, $rules, $customMessages);
            $post = new Post();
    		$post->Title = $request->title;
    		$post->Text = $request->text;
    		$post->user_id = Auth::user()->id;
             if($request->image)
                {
                    $exploded = explode(",", $request->image);
                    // decode
                    $decode = base64_decode($exploded[1]);
                    $filename = $request->filename;
                    $dossier = 'images/posts';   
                    if (!File::exists($dossier)) {
                        $oldmask = umask(0);
                        mkdir($dossier, 0777, TRUE);
                        umask( $oldmask);
                    }
                     
                    $path = $dossier.'/'.$filename;      
                    file_put_contents($path, $decode);
                    $post->Image = '/'.$path; 
                 }

               //if user choose save and publish  
            if($request->action == 1){
                $post->is_published = 1;
                $post->published_by = Auth::user()->id;
            }
                 
    		$post->save();
            $post->categories()->sync($request->categories);
    		return $data =[
	    			  'post' =>$post,
	    		      'etat' => 1
    		        ];
    		
    	} catch (Exception $e) {
    		return $data =[
	    			  'error' => $e->getMessage(),
	    		      'etat' => 0
    		        ];
    		
    	}
    }
    //Update post 
    public function update($id,Request $request) {

        try {
            $rules = [
                'title' => 'required',
                'text' => 'required',
                'categories' => 'required',
            ];

            $customMessages = [
                'title.required' => 'Le champ titre est obligatoire.',
                'text.required'  => 'Le contenu de votre post est obligatoire.',
                'categories.required' => 'Veuillez choisir une catégorie.',

            ];
            $this->validate($request, $rules, $customMessages);
            $post = Post::find($id);
            $post->Title = $request->title;
            $post->Text = $request->text;
            if($request->image)
                {
                    $exploded = explode(",", $request->image);
                    // decode
                    $decode = base64_decode($exploded[1]);
                    $filename = $request->filename;
                    $dossier = 'images/posts';   
                    if (!File::exists($dossier)) {
                        $oldmask = umask(0);
                        mkdir($dossier, 0777, TRUE);
                        umask( $oldmask);
                    }
                     
                    $path = $dossier.'/'.$filename;      
                    file_put_contents($path, $decode);
                    $post->Image = '/'.$path; 
                 }
            $post->save();
            $post->categories()->sync($request->categories);
            
        } catch (Exception $e) {

            return $data =[
                      'error' => $e->getMessage(),
                      'etat' => 0
                    ];
            
        }


    }

    //Delete post
  public function destroy($id){

    try {

         $post = Post::find($id);
         $post->categories()->detach();
         $post->delete();
        
    } catch (Exception $e) {
        return $data =[
                      'error' => $e->getMessage(),
                      'etat' => false,
                    ];
    }
  }  
  //Filtre posts
  public function filterPosts(Request $request) {
    try {
            $posts = Post::where('is_published',1)
             ->when($request->categories , function ($query) use ($request) {
                     $query->whereHas('categories', function($q) use ($request){
                                 $q->whereIn('post_categorie.categorie_id',$request->categories);
                        });
             })->when($request->title, function ($query) use ($request) {
                $query->where('title','LIKE','%'.$request->title.'%');
             })->with('user')->with('publisher')->with('categories')->paginate(9);       
            return $data =[
                         'posts' => $posts,
                         'etat' => 1
                      ];

        }catch(Exception $e){
             return $data =[
                      'error' => $e->getMessage(),
                      'etat' => 0
                    ];
              
        }
  }
  //Load all  posts's connected user

    public function LoadMyPosts(){

        try{

            $posts = Auth::user()->posts()->with('user')->with('publisher')->with('categories')->paginate(9);
            
            return $data =[
                         'posts' => $posts,
                         'etat' => 1
                      ];

        }catch(Exception $e){
             return $data =[
                      'error' => $e->getMessage(),
                      'etat' => 0
                    ];
              
        }
    }
    public function publishpost(Request $request){
         try {
            $post = Post::find($request->postId);
            $post->is_published = 1;
            $post->published_by = Auth::user()->id;
            $post->save();
            return $data =[
                      'post' =>$post,
                      'etat' => 1
                    ];
             
         } catch (Exception $e) {
            return $data =[
                      'error' => $e->getMessage(),
                      'etat' => 0
                    ];
             
         }
    }
}
