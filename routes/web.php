<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin', 'AdminController@loginAdmin');
Route::post('/admin', 'AdminController@postLoginAdmin');

Route::get('/home', function () {
    return view('home');
});
Route::prefix('admin')->group(function () {
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/',[
            'as'=>'index',
            'uses'=>'CategoryController@index'
        ] );
        Route::get('/create',[
            'as'=>'create',
            'uses'=>'CategoryController@create'
        ] );
        Route::post('/',[
            'as'=>'store',
            'uses'=>'CategoryController@store'
        ] );
        Route::get('/edit/{id}',[
            'as'=>'edit',
            'uses'=>'CategoryController@edit'
        ] );
        Route::put('/update/{id}',[
            'as'=>'update',
            'uses'=>'CategoryController@update'
        ] );
        Route::get('/delete/{id}',[
            'as'=>'destroy',
            'uses'=>'CategoryController@destroy'
        ] );

    });

    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('/',[
            'as'=>'index',
            'uses'=>'MenuController@index'
        ] );
        Route::get('/create',[
            'as'=>'create',
            'uses'=>'MenuController@create'
        ] );
        Route::post('/',[
            'as'=>'store',
            'uses'=>'MenuController@store'
        ] );
        Route::get('/{id}/edit',[
            'as'=>'edit',
            'uses'=>'MenuController@edit'
        ] );
        Route::put('/{id}',[
            'as'=>'update',
            'uses'=>'MenuController@update'
        ] );
        Route::get('/delete/{id}',[
            'as'=>'destroy',
            'uses'=>'MenuController@destroy'
        ] );

    });

});


