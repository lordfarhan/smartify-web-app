<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Quote;
use App\QuoteCategory;
use Exception;

class QuoteController extends Controller
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

  public function getCategories()
  {
    try {
      $categories = QuoteCategory::all();
      return response()->json([
        'success' => true,
        'message' => 'Successfully get categories.',
        'result' => $categories
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function getRandomQuotes()
  {
    try {
      $quote = Quote::all();
      $random_quote = array();
      if ($quote->count() >= 10) {
        $random_quote =  $quote->random(10)->all();
      } else {
        $random_quote =  $quote->random($quote->count())->all();
      }
      return response()->json([
        'success' => true,
        'message' => 'Successfully get random quotes.',
        'result' => $random_quote
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function getByCategoryId($id)
  {
    try {
      $quote = Quote::where('quote_category_id', $id)->get();
      $random_quote = array();
      if ($quote->count() >= 10) {
        $random_quote =  $quote->random(10)->all();
      } else {
        $random_quote =  $quote->random($quote->count())->all();
      }
      return response()->json([
        'success' => true,
        'message' => 'Successfully get random quotes by category.',
        'result' => $random_quote
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }
}
