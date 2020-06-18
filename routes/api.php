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

Route::group(['prefix' => 'v1'], function() {
  Route::group(['prefix' => 'auth'], function() {
    Route::post('register', '\\App\\Api\\V1\\Controllers\\Auth\\RegisterController@register');
    Route::post('login', '\\App\\Api\\V1\\Controllers\\Auth\\LoginController@login');
    Route::post('recover', '\\App\\Api\\V1\\Controllers\\Auth\\ForgotPasswordController@recover');
    Route::post('refresh', '\\App\\Api\\V1\\Controllers\\Auth\\RefreshController@refresh');
    Route::get('logout', '\\App\\Api\\V1\\Controllers\\Auth\\LogoutController@logout');
    Route::get('verify/{verification_code}', '\\App\\Api\\V1\\Controllers\\Auth\\VerificationController@verify');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
    Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');
    Route::get('me', '\\App\\Api\\V1\\Controllers\\UserController@me');
  });

  Route::group(['prefix' => 'courses'], function() {
    Route::get('featured', '\\App\\Api\\V1\\Controllers\\CourseController@featured');
    Route::get('owned', '\\App\\Api\\V1\\Controllers\\CourseController@owned');
    Route::post('/enroll', '\\App\\Api\\V1\\Controllers\\CourseController@enroll');
    Route::get('/{id}', '\\App\\Api\\V1\\Controllers\\CourseController@getById');

    Route::get('/{id}/chapters', '\\App\\Api\\V1\\Controllers\\ChapterController@getByCourseId');
    
    Route::get('/{id}/tests', '\\App\\Api\\V1\\Controllers\\TestController@getByCourseId');
    
    Route::get('/{id}/reviews', '\\App\\Api\\V1\\Controllers\\CourseReviewController@getByCourseId');
    Route::post('/review', '\\App\\Api\\V1\\Controllers\\CourseReviewController@addReview');

    Route::get('/{course_id}/chapters/{chapter_id}/sub-chapters', '\\App\\Api\\V1\\Controllers\\SubChapterController@getByChapterId');
  });
});
