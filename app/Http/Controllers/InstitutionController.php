<?php

namespace App\Http\Controllers;

use App\Imports\InstitutionActivationCodesImport;
use App\Institution;
use App\InstitutionActivationCode;
use App\UserInstitution;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\ImageManagerStatic as Image;

class InstitutionController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:institution-list|institution-create|institution-edit|institution-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:institution-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:institution-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:institution-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $institutions = Institution::all();
    return view('institutions.index', compact('institutions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('institutions.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:60',
      'image' => 'mimes:jpg,png,jpeg,JPG',
    ]);

    $input = $request->all();

    if (!empty($request->file('image'))) {
      $image = $request->file('image');
      $imageName = 'institutionImage' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', request('name')) . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(storage_path('app/public/institutions/') . $imageName);
      $input['image'] = 'institutions/' . $imageName;
    } else {
      $input = array_except($input, array('image'));
    }

    Institution::create($request->all());
    return redirect()->route('institutions.index')->with('success', 'Added institution successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Institution  $institution
   * @return \Illuminate\Http\Response
   */
  public function show(Institution $institution)
  {
    $activation_codes = $institution->activationCodes;
    // dd($activation_codes);
    return view('institutions.show', compact('institution', 'activation_codes'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Institution  $institution
   * @return \Illuminate\Http\Response
   */
  public function edit(Institution $institution)
  {
    return view('institutions.edit', compact('institution'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Institution  $institution
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Institution $institution)
  {
    $this->validate($request, [
      'name' => 'required|max:60',
      'image' => 'mimes:jpg,png,jpeg,JPG',
    ]);

    $input = $request->all();

    if (!empty($request->file('image'))) {
      // Deleting existing image
      if (File::exists(storage_path('app/public/' . $institution->image))) {
        File::delete(storage_path('app/public/' . $institution->image));
      }
      $image = $request->file('image');
      $imageName = 'institutionImage' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', request('name')) . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(storage_path('app/public/institutions/') . $imageName);
      $input['image'] = 'institutions/' . $imageName;
    } else {
      $input = array_except($input, array('image'));
    }

    $institution->update($input);
    return redirect()->route('institutions.index')->with('success', 'Added institution successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Institution  $institution
   * @return \Illuminate\Http\Response
   */
  public function destroy(Institution $institution)
  {
    if (File::exists(storage_path('app/public/' . $institution->image))) {
      File::delete(storage_path('app/public/' . $institution->image));
    }

    $institution->delete();
    return redirect()->route('institutions.index')->with('success', 'Deleted institutions successfully');
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function importKeys()
  {
    Excel::import(new InstitutionActivationCodesImport, request()->file('file'));
    return back()->with('success', 'Successfully imported');
  }

  public function deleteKey(Request $request)
  {
    $this->validate($request, ['id' => 'required']);

    try {
      $key = InstitutionActivationCode::find($request->id);
      UserInstitution::where('user_id', $key->user_id)->where('institution_id', $key->institution_id)->first()->delete();
      $key->delete();
      return back()->with('success', 'Successfully deleted.');
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }
}
