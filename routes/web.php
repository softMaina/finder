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


Route::get('/', [
    'as' => 'index',
    'uses' => 'PagesController@index'
]);


Route::post('search/shops', [
    'uses' => 'ShopController@search',
    'as' => 'shops.search'
]);

Route::get('shop/{shop}', [
    'uses' => 'PagesController@shopdetails',
    'as' => 'shop.details'
]);

Route::get('/gallery', [
    'as' => 'gallery',
    'uses' => 'PagesController@gallery'
]);

Route::post('shop/visit', [
    'uses' => 'ShopController@shopvisit',
    'as' => 'shop.visit'
]);

Route::post('shop/requestvisit', [
    'uses' => 'ShopController@requestvisit',
    'as' => 'shop.requestvisit'
]);

Route::post('shop/pay', [
    'uses' => 'ShopController@shoppay',
    'as' => 'shop.pay'
]);
Route::post('signin', [
    'uses' => 'UserController@postSignIn',
    'as' => 'user.signin'
]); //


/*=================== ==================
================= Cart =================
========================================*/
Route::get('cart', 'ProductsController@cart');

Route::get('add-to-cart/{id}', 'ProductsController@addToCart');

Route::patch('update-cart', 'ProductsController@update');

Route::delete('remove-from-cart', 'ProductsController@remove');

/*=================== ==================
================= End Cart =================
========================================*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => '{role}'], function ($role) {
    Route::get('/dashboard', [
        'middleware' => ['auth'],
        'roles' => ['Admin', 'Landlord', 'Tenant'],
        'as' => 'dashboard',
        'uses' => 'PagesController@dashboard'
    ]);

    Route::get('/shops', [
        'middleware' => ['roles', 'auth'],
        'roles' => ['Admin', 'Landlord', 'Tenant'],
        'as' => 'shops',
        'uses' => 'PagesController@shops'
    ]);

    Route::get('/users', [
        'middleware' => ['roles', 'auth'],
        'roles' => ['Admin'],
        'as' => 'users',
        'uses' => 'PagesController@users'
    ]);

    Route::get('/tenants', [
        'middleware' => ['roles', 'auth'],
        'roles' => ['Admin'],
        'as' => 'tenants',
        'uses' => 'PagesController@tenants'
    ]);


    Route::get('/landlords', [
        'middleware' => ['roles', 'auth'],
        'roles' => ['Admin'],
        'as' => 'landlords',
        'uses' => 'PagesController@landlords'
    ]);
    Route::get('/user/{id}', [
        'middleware' => ['roles', 'auth'],
        'roles' => ['Admin'],
        'as' => 'users.id',
        'uses' => 'PagesController@userId'
    ]);

    Route::get('/visits', [
        'middleware' => ['roles', 'auth'],
        'roles' => ['Admin', 'Tenant'],
        'as' => 'visits',
        'uses' => 'PagesController@visits'
    ]);

    Route::get('/profile', [
        'middleware' => ['roles', 'auth'],
        'roles' => ['Admin', 'Landlord', 'Tenant'],
        'as' => 'profile',
        'uses' => 'PagesController@profile'
    ]);
});


/*
 *
 *    Get Shops
 *
 * */

Route::get('shops', [
    'uses' => 'ShopController@index',
    'as' => 'shops.all',
]);
Route::post('shops', [
    'middleware' => 'auth',
    'uses' => 'ShopController@store',
    'as' => 'shops.create'
]);

Route::put('shops/update', [
    'uses' => 'ShopController@update',
    'as' => 'shops.update',
    'middleware' => 'auth'
]);

Route::post('shops/delete', [
    'uses' => 'ShopController@delete',
    'as' => 'shops.delete',
    'middleware' => 'auth'
]);

/*
 *
 *    Get Tenant
 *
 * */

Route::get('user', [
    'uses' => 'UserController@index',
    'as' => 'user.all',
]);

Route::get('tenants', [
    'uses' => 'UserController@tenants',
    'as' => 'user.tenants',
]);

Route::get('landlords', [
    'uses' => 'UserController@landlords',
    'as' => 'user.landlords',
]);

Route::get('user/{id}', [
    'uses' => 'PagesController@userId',
    'as' => 'user.id',
]);

Route::get('visits', [
    'uses' => 'UserController@visits',
    'as' => 'user.visits',
]);

Route::post('user', [
    'middleware' => 'auth',
    'uses' => 'UserController@store',
    'as' => 'user.create'
]);

Route::post('user/update', [
    'uses' => 'UserController@update',
    'as' => 'user.update',
    'middleware' => 'auth'
]);

Route::post('user/delete', [
    'uses' => 'UserController@delete',
    'as' => 'user.delete',
    'middleware' => 'auth'
]);

// Dennis Mwea
Route::get('/search', 'PagesController@search');
Route::group(['middleware' => 'auth'], function () {
    Route::post('/shops/favorite/{shop}', 'PagesController@favoriteShop');
});
