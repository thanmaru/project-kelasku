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
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::prefix('c')->group(function(){
	Route::get('{code}', 'Main\ClassroomController@index')->name('classroom');
	Route::post('save', 'Main\ClassroomController@save')->name('classroom.save');
	Route::post('join', 'Main\ClassroomController@join')->name('classroom.join');
	Route::post('leave/{id}', 'Main\ClassroomController@leave')->name('classroom.leave');
	Route::get('delete-member/{user}{class}', 'Main\ClassroomController@deleteMember')->name('classroom.delete-member');

	//Exam
	Route::get('create-exam/{id}', 'Main\ClassroomController@createExam')->name('classroom.create-exam');
	Route::post('save-exam/{id}', 'Main\ClassroomController@saveExam')->name('classroom.save-exam');
	Route::get('create-announce/{id}', 'Main\ClassroomController@createAnnouncement')->name('classroom.create-announce');

	Route::prefix('{code}/assignemnt')->group(function(){
		Route::get('/{id}', 'Main\TestController@index')->name('test');
		Route::get('/{id}/start', 'Main\TestController@start')->name('test.start');
		Route::get('/{id}/submission', 'Main\TestController@submission')->name('test.submission');
		Route::post('/{id}/submit', 'Main\TestController@submit')->name('test.submit');
		Route::get('/{id}/delete', 'Main\TestController@delete')->name('test.delete');
	});
	Route::prefix('{code}/create')->group(function(){
		Route::get('assignment', 'Main\TestController@create')->name('test.create');
		Route::post('assignment/save', 'Main\TestController@save')->name('test.save');
	});

	Route::prefix('{code}/announcement')->group(function(){
		Route::get('/{id}', 'Main\AnnouncementController@index')->name('announcement');
		Route::post('save', 'Main\AnnouncementController@save')->name('announcement.save');
	});
});

Route::prefix('t')->group(function(){
	Route::get('/', 'HomeController@tasklist')->name('tasklist');
});


