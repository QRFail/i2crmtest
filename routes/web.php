<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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



Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', 'ApiController@index');
});

Route::middleware('throttle:30,1')->group(function () {
    Route::get('/api/getLastPushedRepositories', 'ApiController@getLastPushedRepositories');
});

