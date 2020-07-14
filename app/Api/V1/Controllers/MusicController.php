<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Music;

class MusicController extends Controller
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

  public function get()
  {
    $musics = Music::all()->random(10);
    return response()->json([
      'success' => true,
      'message' => 'Successfully fetched musics.',
      'result' => $musics
    ]);
  }
}
