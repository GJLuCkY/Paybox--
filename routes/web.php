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

Route::group(['middleware' => ['auth']], function()
{
    Route::get('/', 'FrontController@home')->name('pages.home');
    Route::post('next-day', 'FrontController@nextDay')->name('next.day');
    Route::get('/translation/{id}', 'FrontController@index');
});


