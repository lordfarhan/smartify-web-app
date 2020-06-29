<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Material;
use Exception;
use Illuminate\Http\Request;

class MaterialController extends Controller
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

  public function getBySubChapterId(Request $request, $course_id, $chapter_id, $sub_chapter_id)
  {
    try {
      $materials = Material::where('sub_chapter_id', $sub_chapter_id)->orderBy('order', 'asc')->get();

      if (count($materials) > 0) {
        return response()->json([
          'success' => true,
          'message' => 'Successfully retrieved materials',
          'result' => $materials
        ], 200);
      } else {
        return response()->json([
          'success' => true,
          'message' => 'No material found',
          'result' => null
        ], 204);
      }
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => "Process error, please try again later.",
        'result' => null
      ], 500);
    }
  }
}
