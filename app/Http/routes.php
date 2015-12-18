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

Route::get('/', [
    'as'    => 'home',
    'uses'  => 'PhotoController@index'
]);

Route::post('/photo/store', [
    'as'    => 'photo.store',
    'uses'  => 'PhotoController@store'
]);

Route::get('photo/{slug}', [
    'as'    => 'photo.serve',
    'uses'  => 'PhotoController@serve'
]);
