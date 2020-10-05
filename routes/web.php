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
Route::resource('candidats','Candidat\CandidatController');
Route::resource('presents','Present\PresentController');

Route::get('/states/{state}/destroy_all', 'State\StateController@destroy_all')->name('states.destroy_all');
Route::get('/states/{state}/candidats_', 'State\StateController@candidats_')->name('states.candidats');

Route::post('/districts/search', 'District\DistrictController@search')->name('districts.search');
Route::get('/districts/{state_?}/create_', 'District\DistrictController@create_')->name('districts.create_');

Route::get('/candidats//upload', 'Candidat\CandidatController@upload')->name('candidats.upload');
Route::post('/candidats/read_file', 'Candidat\CandidatController@read_file')->name('candidats.read_file');
Route::get('/candidats/erors', 'Candidat\CandidatController@erors')->name('candidats.erors');
Route::post('/candidats/search', 'Candidat\CandidatController@search')->name('candidats.search');
Route::get('/candidats/{type}/candidat_', 'Candidat\CandidatController@candidat_')->name('candidats.candidat_');

Route::get('/parties/{party}/type', 'Party\PartyController@type')->name('parties.type');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/repair', 'HomeController@repair')->name('repair');
