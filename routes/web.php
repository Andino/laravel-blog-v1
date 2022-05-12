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

Auth::routes();

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::put('/profile', 'HomeController@update')->name('users.profile');
    
    Route::resource('users', 'UserController');
    Route::resource('blogs', 'BlogController');
});
