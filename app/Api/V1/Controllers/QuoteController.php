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
      foreach ($categories as $category) {
        if (!filter_var($category->image, FILTER_VALIDATE_URL)) {
          $category['image'] = url('storage/' . $category->image);
        }
      }
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
      $random_quotes = array();
      if ($quote->count() >= 10) {
        $random_quotes =  $quote->random(10)->all();
      } else {
        $random_quotes =  $quote->random($quote->count())->all();
      }
      foreach ($random_quotes as $quote) {
        if (!filter_var($quote->image, FILTER_VALIDATE_URL)) {
          $quote['image'] = url('storage/' . $quote->image);
        }
      }
      return response()->json([
        'success' => true,
        'message' => 'Successfully get random quotes.',
        'result' => $random_quotes
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
      $random_quotes = array();
      if ($quote->count() >= 10) {
        $random_quotes =  $quote->random(10)->all();
      } else {
        $random_quotes =  $quote->random($quote->count())->all();
      }
      foreach ($random_quotes as $quote) {
        if (!filter_var($quote->image, FILTER_VALIDATE_URL)) {
          $quote['image'] = url('storage/' . $quote->image);
        }
      }
      return response()->json([
        'success' => true,
        'message' => 'Successfully get random quotes by category.',
        'result' => $random_quotes
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
