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

Route::get('student', 'StudentController@show');
Route::get('student/create', 'StudentController@create');
Route::get('student/edit/{id}', 'StudentController@edit');
Route::post('student', 'StudentController@store');
Route::post('student/update/{id}', 'StudentController@update');
Route::delete('student/delete/{id}', 'StudentController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
