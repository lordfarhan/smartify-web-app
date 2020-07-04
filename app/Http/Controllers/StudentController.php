<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInstitution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:user-delete', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (Auth::user()->hasRole('Master')) {
      $data = User::role(['student'])->orderBy('id', 'desc')->get();
    } else {
      $user_ids = UserInstitution::where('institution_id', Auth::user()->institutions->pluck('institution_id'))->pluck('user_id');
      $data = User::whereIn('id', $user_ids)->role(['student'])->orderBy('id', 'desc')->get();
    }
    return view('users.index', compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
