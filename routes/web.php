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
Route::get('/home', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('institutions', 'InstitutionController');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('subjects', 'SubjectController');
    Route::resource('grades', 'GradeController');
    Route::resource('courses', 'CourseController');
    Route::get('courses/{id}/schedule', 'CourseController@editSchedule');
    Route::post('courses/schedule', 'CourseController@updateSchedule')->name('courses.updateSchedule');
    Route::get('courses.delete-file/{id}/{type}', 'CourseController@deleteFile');
    Route::get('courses/{course_id}/tests/{id}', 'TestController@show');

    Route::resource('chapters', 'ChapterController');
    Route::post('chapters.edit', 'ChapterController@update');
    Route::post('chapters.delete', 'ChapterController@destroy');
    Route::post('chapters.delete-file', 'ChapterController@deleteFile');

    Route::resource('sub-chapters', 'SubChapterController');
    Route::post('sub-chapters.edit', 'SubChapterController@update');
    Route::post('sub-chapters.delete', 'SubChapterController@destroy');

    Route::resource('tests', 'TestController');
    Route::post('tests.edit', 'TestController@update');
    Route::post('tests.delete', 'TestController@destroy');

    Route::resource('questions', 'QuestionController');
    Route::post('questions.delete', 'QuestionController@destroy');
    Route::get('/questions.delete-file/{id}/{type}', 'QuestionController@deleteFile');

    Route::resource('schedules', 'ScheduleController');
    Route::get('schedules.all', 'ScheduleController@getScheduleData');
});