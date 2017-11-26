<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//create new account
Route::post('/users','UsersController@post');

//authenticate user (login)
Route::post('/users/authenticate','Users\AuthController@post');

//create new film
Route::post('/films','FilmsController@post');

//get list of all films
Route::get('/films','FilmsController@get');

//get a single film
Route::get('/films/{filmId}', 'Films\FilmController@get')->where('filmId', '[a-zA-Z0-9\-]+');

//Add a comment to a film
Route::post('/films/{filmId}/comments', 'Films\Film\CommentsController@post')->where('filmId', '[a-zA-Z0-9\-]+');

//get all comments of a film
Route::get('/films/{filmId}/comments', 'Films\Film\CommentsController@get')->where('filmId', '[a-zA-Z0-9\-]+');