<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('subjects', 'SubjectController');
    Route::resource('grades', 'GradeController');
    Route::resource('courses', 'CourseController');
    Route::get('course-delete-file/{id}/{type}', 'CourseController@deleteFile');

    Route::resource('chapters', 'ChapterController');
    Route::post('chapter-edit', 'ChapterController@update');
    Route::post('chapter-delete', 'ChapterController@destroy');
    
    Route::resource('sub-chapters', 'SubChapterController');
});
