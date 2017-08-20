<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// general website routes, doesn't need authentication
Route::get('/', 'ItemController@getItems')->name('dashboard');
Route::get('items/{category_id}','ItemController@getCategoryItems')->name('items');
Route::get('image_item/{filename}','ItemController@getItemImage')->name('image_item');
Route::get('add_to_cart/{item_id}','ItemController@addToCart')->name('add_to_cart');
Route::get('get_cart','ItemController@getCart')->name('get_cart');
Route::get('reduce_item/{item_id}', 'ItemController@reduceItem')->name('reduce_item');
Route::get('remove_item/{item_id}', 'ItemController@removeItem')->name('remove_item');
Route::get('search', 'ItemController@searchItems')->name('search');

// only logged in users can checkout and check orders
Route::get('checkout', 'ItemController@checkout')->middleware('auth')->name('checkout');
Route::get('orders', 'UserController@getOrders')->middleware('auth')->name('orders');

// admin group
Route::group(['prefix'=>'admin', 'namespace' => 'Admin'], function() {
    // only not logged in group, redirect logged admin to dashboard
    Route::group(['middleware'=>'guest'], function() {
        Route::get('login', function () {
            return view('admin.login');
        })->name('admin_login_page');
        Route::post('login','AdminController@login')->name('admin_login');
    });

    //logged in group
    Route::group(['middleware'=>'auth.admin'], function() {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('admin_dashboard');
        Route::get('logout','AdminController@logout')->name('admin_logout');

        // categories routes
        Route::get('categories','CategoryController@getCategories')->name('admin_getCategories');
        Route::post('add_category','CategoryController@addCategory')->name('admin_addCategory');
        Route::get('delete_category','CategoryController@deleteCategory')->name('admin_deleteCategory');
        Route::get('edit_category','CategoryController@editCategory')->name('admin_editCategory');

        // items routes
        Route::get('items','ItemController@getItems')->name('admin_getItems');
        Route::post('add_item','ItemController@addItem')->name('admin_addItem');
        Route::get('delete_item','ItemController@deleteItem')->name('admin_deleteItem');
        Route::get('edit_item','ItemController@editItem')->name('admin_editItem');

        // users routes
        Route::get('dashboard','UserController@getUsers')->name('admin_getUsers');
        Route::get('orders/{user_id}','UserController@getOrders')->name('admin_getOrders');
    });
    Route::get('hashing','AdminController@hashing')->name('admin_hashing');
});

// user group
Route::group(['prefix'=>'user'], function() {
    // only not logged in, redirect logged users to dashboard
    Route::group(['middleware'=>'guest'], function() {
        Route::get('login', function () {
            return view('user.login');
        })->name('user_login_page');
        Route::get('register', function () {
            return view('user.register');
        })->name('user_register_page');
        Route::post('login','UserController@login')->name('user_login');
        Route::post('register','UserController@register')->name('user_register');
    });
    Route::get('logout','UserController@logout')->name('user_logout');
});
