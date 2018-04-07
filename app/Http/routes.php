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

Route::get('/', 'WelcomeController@index');
Route::get('/non-ajax', 'WelcomeController@nonAjax');
Route::post('/user/store-non-ajax', 'UserController@storeNonAjax');
// Route::get('/user/edit/{uuid}', 'UserController@edit');
// Route::get('/user/edit/{uuid}', 'UserController@edit');
// Route::post('/user/update/{uuid}', 'UserController@update');
Route::resources([
    'user' => 'UserController'
]);
