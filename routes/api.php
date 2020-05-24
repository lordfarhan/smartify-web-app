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
Route::post('register', '\\App\\Api\\V1\\AuthController@register');
Route::post('login', '\\App\\Api\\V1\\AuthController@login');
Route::post('recover', '\\App\\Api\\V1\\AuthController@recover');
Route::get('verify/{verification_code}', '\\App\\Api\\V1\\AuthController@verify');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
// Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', '\\App\\Api\\V1\\AuthController@logout');
    Route::get('me', '\\App\\Api\\V1\\AuthController@me');

    Route::get('courses', '\\App\\Api\\V1\\CourseController@get');
});
