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

Route::get('/', function () {
    return view('welcome');
});



Route::auth();

Route::get('/home', 'HomeController@index');



Route::group(['prefix'=>'api'], function () {
    Route::post('authenticate', ['as' => 'authenticate', 'uses' => 'AuthController@authenticate']);

    /*Route::get('product', ['as' => 'product_index', 'uses' => 'ProductController@index']);
    Route::get('product/{id}', ['as' => 'product_show', 'uses' => 'ProductController@show']);
    Route::post('product', ['as' => 'product_store', 'uses' => 'ProductController@store']);
    Route::patch('product/{id}', ['as' => 'product_edit', 'uses' => 'ProductController@update']);
    Route::delete('product/{id}', ['as' => 'product_delete', 'uses' => 'ProductController@destroy']);*/

    Route::resource('product', 'ProductController');
});
