<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('logs', 'LogsController@apiCreate');

Route::POST('program','ProgramController@apiCreate');

Route::POST('program2', 'ProgramController@apiCreate2');

Route::POST('program/delete', 'ProgramController@apiDelete');

Route::POST('monitors', 'MonitorsController@apiCreate');
