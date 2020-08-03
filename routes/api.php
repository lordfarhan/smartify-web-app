<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {
  Route::group(['prefix' => 'auth'], function () {
    Route::post('register', '\\App\\Api\\V1\\Controllers\\Auth\\RegisterController@register');
    Route::post('login', '\\App\\Api\\V1\\Controllers\\Auth\\LoginController@login');
    Route::post('recover', '\\App\\Api\\V1\\Controllers\\Auth\\ForgotPasswordController@recover');
    Route::post('refresh', '\\App\\Api\\V1\\Controllers\\Auth\\RefreshController@refresh');
    Route::get('logout', '\\App\\Api\\V1\\Controllers\\Auth\\LogoutController@logout');
    Route::get('verify/{verification_code}', '\\App\\Api\\V1\\Controllers\\Auth\\VerificationController@verify');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
    Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');
  });

  Route::group(['prefix' => 'user'], function () {
    Route::get('me', '\\App\\Api\\V1\\Controllers\\UserController@me');
    Route::post('update/{field}', '\\App\\Api\\V1\\Controllers\\UserController@update');
    Route::get('institutions', '\\App\\Api\\V1\\Controllers\\UserController@institutions');
    Route::get('institutions/browse', '\\App\\Api\\V1\\Controllers\\InstitutionController@browse');
    Route::post('institutions/enroll', '\\App\\Api\\V1\\Controllers\\InstitutionController@enroll');
    Route::get('profile', '\\App\\Api\\V1\\Controllers\\UserController@profile');
    Route::get('friends', '\\App\\Api\\V1\\Controllers\\FriendshipController@get');
    Route::get('friends/{id}', '\\App\\Api\\V1\\Controllers\\FriendshipController@detail');
    Route::post('friends/add', '\\App\\Api\\V1\\Controllers\\FriendshipController@add');
    Route::post('friends/accept', '\\App\\Api\\V1\\Controllers\\FriendshipController@accept');
    Route::get('friends/requests', '\\App\\Api\\V1\\Controllers\\FriendshipController@requests');
    Route::get('friends/{id}/status', '\\App\\Api\\V1\\Controllers\\FriendshipController@status');
    Route::get('schedules/events', '\\App\\Api\\V1\\Controllers\\ScheduleEventController@get');
  });

  Route::group(['prefix' => 'courses'], function () {
    Route::get('featured', '\\App\\Api\\V1\\Controllers\\CourseController@featured');
    Route::get('owned', '\\App\\Api\\V1\\Controllers\\CourseController@owned');
    Route::post('/enroll', '\\App\\Api\\V1\\Controllers\\CourseController@enroll');
    Route::get('/{id}', '\\App\\Api\\V1\\Controllers\\CourseController@getById');

    Route::get('/{id}/chapters', '\\App\\Api\\V1\\Controllers\\ChapterController@getByCourseId');

    Route::get('/{id}/tests', '\\App\\Api\\V1\\Controllers\\TestController@getByCourseId');
    Route::post('/{id}/tests/{test_id}/attempt', '\\App\\Api\\V1\\Controllers\\TestController@attempt');
    Route::post('/{id}/tests/{test_id}/submit', '\\App\\Api\\V1\\Controllers\\TestController@submit');

    Route::get('/{id}/tests/{test_id}/questions', '\\App\\Api\\V1\\Controllers\\QuestionController@getByTestId');

    Route::get('/{id}/reviews', '\\App\\Api\\V1\\Controllers\\CourseReviewController@getByCourseId');
    Route::get('/{id}/members', '\\App\\Api\\V1\\Controllers\\CourseController@members');
    Route::get('/{id}/author', '\\App\\Api\\V1\\Controllers\\CourseController@author');
    Route::post('/review', '\\App\\Api\\V1\\Controllers\\CourseReviewController@addReview');

    Route::get('/{course_id}/chapters/{chapter_id}/sub-chapters', '\\App\\Api\\V1\\Controllers\\SubChapterController@getByChapterId');
    Route::get('/{course_id}/chapters/{chapter_id}/sub-chapters/{sub_chapter_id}/finish', '\\App\\Api\\V1\\Controllers\\SubChapterController@finish');

    Route::get('/{course_id}/chapters/{chapter_id}/sub-chapters/{sub_chapter_id}/materials', '\\App\\Api\\V1\\Controllers\\MaterialController@getBySubChapterId');
  });

  Route::group(['prefix' => 'administrations'], function () {
    Route::get('provinces', '\\App\\Api\\V1\\Controllers\\AdministrationController@getProvinces');
    Route::get('provinces/{id}', '\\App\\Api\\V1\\Controllers\\AdministrationController@getRegencies');
    Route::get('provinces/{id}/{regency_id}', '\\App\\Api\\V1\\Controllers\\AdministrationController@getDistricts');
    Route::get('provinces/{id}/{regency_id}/{district_id}', '\\App\\Api\\V1\\Controllers\\AdministrationController@getVillages');
  });

  Route::get('musics', '\\App\\Api\\V1\\Controllers\\MusicController@get');
});
