<?php

use App\Http\Middleware\AdminCheck;
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

// Route::get('/', function () {
//     return view('welcome');
// });

/** Admin Routes */
Route::prefix('app')->middleware([AdminCheck::class])->group(function(){
        /** Tag Routes */
    Route::get('/get_tags', 'TagsController@index');
    Route::post('/create_tag', 'TagsController@store');
    Route::post('/edit_tag', 'TagsController@update');
    Route::post('/delete_tag', 'TagsController@destroy');

        /** Category Routes */
    Route::get('/get_categories', 'CategoryController@index');
    Route::post('/uploads', 'CategoryController@uploadImage');
    Route::post('/create_category', 'CategoryController@store');
    Route::post('/edit_category', 'CategoryController@update');
    Route::post('/delete_category', 'CategoryController@destroy');
    Route::post('/delete_image', 'CategoryController@deleteImage');

        /** Role Routes */
    Route::get('/get_roles', 'RoleController@index');
    Route::post('/create_role', 'RoleController@store');
    Route::post('/edit_role', 'RoleController@update');
    Route::post('/delete_role', 'RoleController@destroy');
    Route::post('/assign_roles', 'RoleController@assignRole');

    /** User Routes */
    Route::get('/get_users', 'UsersController@index');
    Route::post('/create_user', 'UsersController@store');
    Route::post('/edit_user', 'UsersController@update');
    Route::post('/delete_user', 'UsersController@destroy');

    Route::post('/admin_login', 'UsersController@adminLogin');

});

Route::get('/', 'AdminController@index');
Route::get('/logout', 'AdminController@Logout');
Route::any('{slug}', 'AdminController@index');


/**End of Admin Routes */

// Route::any('{slug}', function(){
//     return view('welcome');

// });
