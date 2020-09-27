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
Route::resource('mayors','Mayor\MayorController');
Route::resource('parties','Party\PartyController');
Route::resource('states','State\StateController');
Route::resource('districts','District\DistrictController');
Route::get('/states/{state}/destroy_all', 'State\StateController@destroy_all')->name('states.destroy_all');
Route::get('/districts/{state_?}/create_', 'District\DistrictController@create_')->name('districts.create_');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/repair', 'HomeController@repair')->name('repair');
