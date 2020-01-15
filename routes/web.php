<?php


Route::get('/', function () {
    return view('layouts.app');
});

//Auth::routes();
Route::group(['middleware' => 'jwt.auth'], function(){

	  Route::get('auth/user', 'Auth\LoginController@user');
	  Route::post('auth/logout', 'Auth\LoginController@logout');
	  Route::resource('/posts','PostController');
	  Route::get('/LoadMyPosts','PostController@LoadMyPosts');
	  Route::post('/publishpost','PostController@publishpost');
	  Route::get('/loadMyOffres','OffreController@LoadMyOffres');
	
	  Route::resource('/offres','OffreController');
});
Route::group(['middleware' => 'jwt.refresh'], function(){
  	Route::get('auth/refresh', 'Auth\LoginController@refresh');
});

Route::post('auth/login', 'Auth\LoginController@login');

Route::post('auth/register', 'Auth\RegisterController@register');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/loadPublishedPosts','PostController@LoadPublishedPosts');
Route::get('/loadPublishedOffres','OffreController@LoadPublishedOffres');
Route::get('/LoadCategories','CategorieController@LoadCategories');
Route::get('/LoadSecteurs','SecteurController@LoadSecteurs');
Route::post('/filterPosts','PostController@filterPosts');
Route::post('/filterOffres','OffreController@filterOffre');

Route::get('/{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
