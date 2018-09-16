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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/people','PersonsController@index')->name('person');


Route::post('/person_file','PersonsController@store');

Route::any('/person/delete/{person}','PersonsController@destroy')->name('delete');

Route::any('/person_message','MemosController@store')->name('memo');

Route::get('/publitio','PublitioController@index');

Route::post('/publitio','PublitioController@store');


