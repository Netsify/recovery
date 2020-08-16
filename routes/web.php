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

Route::get('/', 'StudentController@index')->name('students.index');

Route::post('/', 'StudentController@check')->name('students.check');

Route::post('/documents', 'DocumentController@store')->name('documents.store');

Route::post('/send', 'StudentController@sendEmail')->name('students.send');
