<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Route::auth();
Route::get('/login',  'Auth\AuthController@showLoginForm');
Route::post('/login', 'Auth\AuthController@login');
Route::get('/logout', 'Auth\AuthController@logout');

//Navigation
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');
Route::get('/browse', 'HomeController@browse'); 
Route::get('/search', 'HomeController@search'); 

//Search for DVD
Route::get('/search/{dvd}', 'BookController@searchDvd');

Route::resource('book', 'BookController');
//Route::get('book/{id}/pages', 'BookController@getPagesById');
Route::get('book/{id}/{name}', 'BookController@updateNameGet');
Route::post('book/rename', 'BookController@updateName');

Route::get('page/{id}/{disk_number}/{name}', 'BookController@updateDiskGet');
Route::get('new/book/{name}', 'BookController@createNewBook');
