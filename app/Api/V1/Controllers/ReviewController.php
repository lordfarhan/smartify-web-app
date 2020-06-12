<?php

namespace App\Api\V1\Controllers;

use App\CourseReview;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('jwt.auth', []);
  }

  /**
   * API to get forum posts 
   * 
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getByCourseId(Request $request, $course_id)
  {
    try {
      $reviews = CourseReview::where('course_id', $course_id)->get();

      if (count($reviews) > 0) {
        foreach($reviews as $key => $review) {
          $review['user'] = User::find($review->user_id)->name;
          $review['email'] = User::find($review->user_id)->email;
          $review['user_image'] = url('storage/'.User::find($review->user_id)->image);
        }
        return response()->json([
          'success' => true,
          'message' => 'Successfully retrieved reviews',
          'result' => $reviews
        ], 200);
      } else {
        return response()->json([
          'success' => true,
          'message' => 'No review found',
          'result' => null
        ], 204);
      }
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => "Process error, please try again later.".$e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  /**
   * API to add or edit review
   * 
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function review(Request $request) {
    $credentials = $request->only('course_id', 'rating', 'review');
    
    $rules = [
        'course_id' => 'required',
        'rating' => 'required',
        'review' => 'required'
    ];

    $validator = Validator::make($credentials, $rules);
    $existed = CourseReview::where('user_id', Auth::user()->id)->where('course_id', $request->course_id)->pluck('id')->first();

    if($existed != null) {
      try {
        $existedReview = CourseReview::find($existed);
        $existedReview->rating = $request->rating;
        $existedReview->review = $request->review;
        $existedReview->update();

        return response()->json([
          'success' => true,
          'message' => 'Successfully edited review',
          'result' => $existedReview
        ], 200);
      } catch(Exception $e) {
        return response()->json([
          'success' => false,
          'message' => 'Failed to edit review'.$e->getMessage(),
          'result' => null
        ], 500);
      }
    } else {
      try {
        $review = new CourseReview();
        $review->user_id = Auth::user()->id;
        $review->course_id = $request->course_id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();
  
        return response()->json([
          'success' => true,
          'message' => 'Successfully added review',
          'result' => $review
        ], 200);
      } catch(Exception $e) {
        return response()->json([
          'success' => false,
          'message' => 'Failed to add review',
          'result' => null
        ], 500);
      } 
    }
  }
}
