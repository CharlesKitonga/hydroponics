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

Route::get('/', function () {
    return view('welcome');
});

/** Admin Routes */
    /** Tag Routes */
Route::get('app/get_tags', 'TagsController@index');
Route::post('app/create_tag', 'TagsController@store');
Route::post('app/edit_tag', 'TagsController@update');
Route::post('app/delete_tag', 'TagsController@destroy');

    /** Category Routes */
Route::get('app/get_categories', 'CategoryController@index');
Route::post('app/uploads', 'CategoryController@uploadImage');
Route::post('app/create_category', 'CategoryController@store');
Route::post('app/edit_category', 'CategoryController@update');
Route::post('app/delete_category', 'CategoryController@destroy');
Route::post('app/delete_image', 'CategoryController@deleteImage');


/**End of Admin Routes */

Route::any('{slug}', function(){
    return view('welcome');

});
