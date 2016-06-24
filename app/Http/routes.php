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

Route::get('/', 'AppController@login');
Route::post('/checklogin', 'AppController@checklogin');
Route::get('/showbadges', 'AppController@showbadges');
Route::get('/logout', 'AppController@logout');
