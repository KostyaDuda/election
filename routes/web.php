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
Route::resource('members','Member\MemberController');
Route::resource('personals','Personal\PersonalController');
Route::resource('protocols','Protocol\ProtocolController');

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

Route::get('/members//upload', 'Member\MemberController@upload')->name('members.upload');
Route::post('/members/read_file', 'Member\MemberController@read_file')->name('members.read_file');
Route::get('/members/erors', 'Member\MemberController@erors')->name('members.erors');
Route::post('/members/search', 'Member\MemberController@search')->name('members.search');

Route::get('/exportword/all', 'Export\ExportController@export_all')->name('export.export_all');
Route::get('/exportword/all_', 'Export\ExportController@export_all_')->name('export.export_all_');
Route::get('/exportword/{district}/one', 'Export\ExportController@export_one')->name('export.export_one');
Route::get('/exportword/{present}/presents', 'Export\ExportController@export_by_presents')->name('export.export_by_presents');
Route::get('/exportword/check', 'Export\ExportController@check_count')->name('export.check');
Route::get('/exportword/dublicaties', 'Export\ExportController@dublicaties')->name('export.dublicaties');
Route::get('/exportword/kvoty', 'Export\ExportController@kvoty')->name('export.kvoty');
Route::get('/exportword/mains', 'Export\ExportController@mains')->name('export.mains');
Route::get('/exportword/{personal}/export_personals_', 'Export\ExportController@export_personals_')->name('export.export_personals_');
Route::get('/exportword/{type}/protocol', 'Export\ExportController@protocol')->name('export.protocol');
Route::get('/exportword/{state}/protocol_state', 'Export\ExportController@protocol_state')->name('export.protocol_state');

Route::get('/rate','Protocol\ProtocolController@rate')->name('protocols.rate');
Route::get('/rate_list/{type}','Protocol\ProtocolController@rate_list')->name('protocols.rate_list');
Route::get('/rate_state/{state_id}','Protocol\ProtocolController@rate_state')->name('protocols.rate_state');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/repair', 'HomeController@repair')->name('repair');
