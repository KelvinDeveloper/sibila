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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/boards', 'TrelloController@index');


Route::group(['middleware' => ['auth', 'setup']], function () {

    Route::get('/home', 'HomeController@index');
    Route::get('/board/{id}', 'HomeController@board');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/setup', 'SetupController@index');
    Route::post('/setup', 'SetupController@save')->name('setup');
});