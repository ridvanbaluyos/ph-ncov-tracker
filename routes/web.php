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


Route::match(['get'], '/', 'HomeController@getIndex');

Route::match(['get'], '/patient-database', 'HomeController@getPatients');

Route::match(['get'], '/global-stats', 'HomeController@getGlobalStats');

Route::view('/data-sources', 'data-sources');

Route::view('/credits', 'credits');

Route::view('/about', 'about');
