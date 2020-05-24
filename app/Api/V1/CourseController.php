<?php

namespace App\Api\V1;

use App\Course;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CourseController extends Controller {
    /**
     * API get courses, on success return course list
     *
     * @param Request $request
     * @return \App\Course
     */
    public function get(Request $request) {
      $this->validate($request, ['user_id' => 'required']);
      $user = User::find($request->input('user_id'));
      if($user->institution->id == 1) {
        $courses = Course::get();
      } else if($user->institution->id == 2) {
        $courses = Course::where('type', '0')->get();
      } else {
        $courses = Course::where(['institution_id' => $user->institution->id])->get();
      }
      return response()->json([
        'status' => 'success',
        'courses' => $courses
      ]);
    }
}