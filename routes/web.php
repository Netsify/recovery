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

Route::post('/', 'StudentController@checkIIN')->name('students.check_iin');

Route::get('/fullname', 'StudentController@fullName')->name('students.full_name');

Route::post('/fullname', 'StudentController@checkFullName')->name('students.check_full_name');

Route::get('/email', 'StudentController@email')->name('students.email');

Route::post('/email', 'StudentController@checkEmail')->name('students.check_email');

Route::get('/recovery', 'StudentController@recovery')->name('students.recovery');

//Route::post('/recovery', 'StudentController@checkRecovery')->name('students.check_recovery');

Route::post('/documents', 'DocumentController@store')->name('documents.store');

Route::post('/send', 'StudentController@sendEmail')->name('students.send');
