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

Route::post('search', ['as' => 'search', 'uses' => 'SearchController@index']);

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

Route::any('/search', function(){
	$q = Input::get ('q');
	$log = Logs::where('date', 'LIKE', '%'.$q.'%')->orWhere('uname','LIKE','%'.$q.'%')->orWhere('compname', 'LIKE','%'.$q.'%')->orWhere('ipaddress', 'LIKE','%'.$q.'%')->orWhere('os_version', 'LIKE','%'.$q.'%')->orWhere('os_build', 'LIKE','%'.$q.'%')->orWhere('bios_version', 'LIKE','%'.$q.'%')->orWhere('bios_date', 'LIKE','%'.$q.'%')->orWhere('model', 'LIKE','%'.$q.'%')->orWhere('serial', 'LIKE','%'.$q.'%')->get();
	if(count($log) > 0)
		return view('logs.search')->withDetails ($log)->withQuery( $q );
	else
		return view('logs.search')->withMessage('No Details Found. Try to search again!');
});
