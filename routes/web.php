<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('film.list');
});

Route::get('/films/{filmId}', 'Frontend\FilmController@get')->where('filmId', '[a-zA-Z0-9\-]+');

Route::get('/login', function () {
   return view('user.login');
});

Route::get('/register', function () {
   return view('user.register');
});

Route::get('/film/create',function () {
   return view('film.create');
});

Route::get('/films', function () {
   return view('film.list');
});
