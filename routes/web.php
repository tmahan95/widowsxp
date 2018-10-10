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
use Illuminate\Support\Facades\Input;
use WidowsXP\Logs;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
	Route::resource('authors', 'AuthorsController');
	Route::resource('users', 'UsersController');
});

Route::group(['middleware' => 'auth'], function() {
	Route::resource('logs', 'LogsController');
});

Route::group(['middleware' => 'guest', 'prefix' => 'api'], function() {
	Route::resource('api', 'ApiController');
});

Route::post('/logs', 'LogsController@searchLogs');
