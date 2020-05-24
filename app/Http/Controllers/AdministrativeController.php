<?php

namespace App\Http\Controllers;

use App\District;
use App\Regency;
use App\Village;
use Illuminate\Http\Request;

class AdministrativeController extends Controller
{
  /**
   * Get regencies depend on province id
   * 
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return @return \Illuminate\Http\Response
   */
  public function regencies(Request $request, $id) {
    $html = '';
    $regencies = Regency::where('province_id', $id)->get();
    foreach ($regencies as $regency) {
        $html .= '<option value="'.$regency->id.'">'.$regency->name.'</option>';
    }
    return response()->json(['html' => $html]);
  }

  /**
   * Get districts depend on regency id
   * 
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return @return \Illuminate\Http\Response
   */
  public function districts(Request $request, $id) {
    $html = '';
    $districts = District::where('regency_id', $id)->get();
    foreach ($districts as $district) {
        $html .= '<option value="'.$district->id.'">'.$district->name.'</option>';
    }
    return response()->json(['html' => $html]);
  }

  /**
   * Get villages depend on district id
   * 
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return @return \Illuminate\Http\Response
   */
  public function villages(Request $request, $id) {
    $html = '';
    $villages = Village::where('district_id', $id)->get();
    foreach ($villages as $village) {
        $html .= '<option value="'.$village->id.'">'.$village->name.'</option>';
    }
    return response()->json(['html' => $html]);
  }
}
