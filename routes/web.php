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

Route::get('/fullname', 'StudentController@fullname')->name('students.fullname');

Route::post('/fullname', 'StudentController@checkFullName')->name('students.check_fullname');

Route::get('/email', 'StudentController@email')->name('students.email');

Route::post('/email', 'StudentController@checkEmail')->name('students.check_email');

Route::get('/email/thanks', 'StudentController@emailThanks')->name('students.email_thanks');

Route::get('/recovery', 'StudentController@recovery')->name('students.recovery');

Route::get('/recovery/thanks', 'StudentController@recoveryThanks')->name('students.recovery_thanks');

//Route::post('/recovery', 'StudentController@checkRecovery')->name('students.check_recovery');

Route::post('/documents', 'DocumentController@store')->name('documents.store');

Route::post('/send', 'StudentController@sendEmail')->name('students.send');
