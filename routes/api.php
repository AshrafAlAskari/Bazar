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

Route::group(['prefix'=>'v1','namespace'=>'\Api\V1'],function (){

    Route::get('items', 'ItemController@getItems');
    Route::get('items/{category_id}', 'ItemController@getCategoryItems');
    Route::post('search/', 'ItemController@searchItems');

    Route::group(['prefix'=>'user'],function (){
        Route::post('login','UserController@login');
        Route::post('register','UserController@register');
        Route::post('orders', 'UserController@getOrders')->middleware('jwt.token');
        Route::post('orders_cart', 'UserController@getOrdersCart')->middleware('jwt.token');
    });

});
