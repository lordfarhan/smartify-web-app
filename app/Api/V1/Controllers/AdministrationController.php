<?php

namespace App\Api\V1\Controllers;

use App\District;
use App\Http\Controllers\Controller;
use App\Province;
use App\Regency;
use Exception;
use Illuminate\Support\Facades\Request;

class AdministrationController extends Controller
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

  public function getProvinces(Request $request)
  {
    try {
      $provinces = Province::all();
      return response()->json([
        'success' => true,
        'message' => 'Successfully retrieved data.',
        'result' => $provinces->sortBy('name')
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Failed retrieving data.',
        'result' => null
      ], 500);
    }
  }

  public function getRegencies(Request $request, $id)
  {
    $province = Province::find($id);
    try {
      $regencies = $province->regencies;
      return response()->json([
        'success' => true,
        'message' => 'Successfully retrieved data.',
        'result' => $regencies->sortBy('name')
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Failed retrieving data.',
        'result' => null
      ], 500);
    }
  }

  public function getDistricts(Request $request, $id, $regency_id)
  {
    $regency = Regency::find($regency_id);
    try {
      $districts = $regency->districts;
      return response()->json([
        'success' => true,
        'message' => 'Successfully retrieved data.',
        'result' => $districts->sortBy('name')
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Failed retrieving data.',
        'result' => null
      ], 500);
    }
  }

  public function getVillages(Request $request, $id, $regency_id, $district_id)
  {
    $district = District::find($district_id);
    try {
      $villages = $district->villages;
      return response()->json([
        'success' => true,
        'message' => 'Successfully retrieved data.',
        'result' => $villages->sortBy('name')
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Failed retrieving data.',
        'result' => null
      ], 500);
    }
  }
}
