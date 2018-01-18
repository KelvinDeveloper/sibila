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

/**
 * Routes require setup Trello and login
 *
 * */
Route::group(['middleware' => ['auth', 'setup']], function () {

    /* Initial */
    Route::get('/home', 'HomeController@index');
    Route::get('/board/{id}', 'BoardController@index');

    /* Board setting */
    Route::post('/board/{id}/settings/save', 'BoardController@save');

    /* Cards automate creation */
    Route::get('/board/{id}/automate/{id_list}', 'AutomateController@index');
    Route::get('/board/{id}/automate/{id_list}/{id_automate}', 'AutomateController@form');
    Route::post('/board/{id}/automate/{id_list}/{id_automate}/save', 'AutomateController@save');
    Route::post('/board/{id}/automate/{id_list}/{id_automate}/delete', 'AutomateController@delete');
});

/**
 * Routes require login
 *
 * */
Route::group(['middleware' => 'auth'], function () {
    Route::get('/setup', 'SetupController@index');
    Route::post('/setup', 'SetupController@save')->name('setup');
});

Route::group([
    'prefix' => 'api/v1/',
    'middleware' => 'cors'
], function () {

    Route::resource('authenticate', 'ApiAuthController', [
//        'except' => [
//            'index',
//            'show',
//            'update',
//            'destroy'
//        ]
    ]);

    Route::get('boards/get', 'ApiController@getBoards');
    Route::match(['post', 'get'], 'report/{id}/get', 'ApiController@getReport');
});