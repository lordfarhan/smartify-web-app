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

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function () {
  Route::get('/dashboard', 'HomeController@index')->name('dashboard');
  Route::resource('institutions', 'InstitutionController');
  Route::post('institutions/add-activation-code', 'InstitutionController@importKeys');
  Route::post('institutions/remove-activation-code', 'InstitutionController@deleteKey');
  Route::resource('users', 'UserController');
  Route::resource('roles', 'RoleController');
  Route::resource('teachers', 'TeacherController');
  Route::resource('students', 'StudentController');
  Route::resource('subjects', 'SubjectController');
  Route::resource('grades', 'GradeController');
  Route::resource('courses', 'CourseController');
  Route::resource('musics', 'MusicController');
  Route::get('/me', 'UserController@me');
  Route::get('/me/edit', 'UserController@editMe')->name('me.edit');
  Route::get('courses/{id}/schedule', 'CourseController@editSchedule');
  Route::post('courses/schedule', 'CourseController@updateSchedule')->name('courses.updateSchedule');
  Route::get('courses.delete-file/{id}/{type}', 'CourseController@deleteFile');
  Route::get('courses/{course_id}/tests/{id}', 'TestController@show');
  Route::get('courses/{course_id}/tests/{id}/submissions', 'TestController@openSubmissions');
  Route::get('courses/{course_id}/tests/{id}/submissions/{mark_id}/delete', 'TestController@deleteMark');
  Route::get('courses/{course_id}/schedules/{schedule_id}/attendances', 'AttendanceController@show');
  Route::get('courses/{course_id}/forum/create', 'ForumPostController@create');
  Route::get('courses/{course_id}/forum/{slug}', 'ForumPostController@show');
  Route::get('courses/{course_id}/forum/{slug}/edit', 'ForumPostController@edit');
  Route::get('courses/{course_id}/forum/{slug}/delete', 'ForumPostController@delete');
  Route::get('courses/{course_id}/forum/{slug}/replies/{reply_id}/edit', 'ForumReplyController@edit');
  Route::get('courses/{course_id}/forum/{slug}/replies/{reply_id}/delete', 'ForumReplyController@delete');

  Route::get('courses/{id}/{chapter_id}/{sub_chapter_id}', 'CourseController@showMaterials');

  Route::post('courses/storeMaterial', 'MaterialController@store')->name('materials.store');
  Route::post('courses/deleteMaterial', 'MaterialController@delete')->name('materials.delete');
  Route::post('courses/updateMaterial', 'MaterialController@update')->name('materials.update');

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
  Route::get('schedules/{id}/attendances/create', 'AttendanceController@create');

  Route::resource('attendances', 'AttendanceController');

  Route::resource('forumPosts', 'ForumPostController');
  Route::resource('forumReplies', 'ForumReplyController');

  Route::get('settings', 'SettingController@index')->name('settings.index');

  Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
  });
});

Route::get('administratives/provinces/{id}/regencies', 'AdministrativeController@regencies');
Route::get('administratives/regencies/{id}/districts', 'AdministrativeController@districts');
Route::get('administratives/districts/{id}/villages', 'AdministrativeController@villages');
Route::get('lang/{locale}', 'HomeController@lang');
