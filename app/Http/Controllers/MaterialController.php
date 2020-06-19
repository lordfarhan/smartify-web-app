<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
    $this->validate($request, [
      'sub_chapter_id' => 'required',
      'order' => 'required',
      'content' => 'required',
    ]);

    Material::create($request->all());

    return back()->with('success', 'Material added successfully');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Material  $material
   * @return \Illuminate\Http\Response
   */
  public function show(Material $material)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Material  $material
   * @return \Illuminate\Http\Response
   */
  public function edit(Material $material)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Material  $material
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $this->validate($request, [
      'id' => 'required',
      'order' => 'required',
      'content' => 'required',
    ]);

    $material = Material::find($request->id);
    $material->order = $request->order;
    $material->content = $request->content;
    $material->update();

    return back()->with('success', 'Material updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Material  $material
   * @return \Illuminate\Http\Response
   */
  public function destroy(Material $material)
  {
    //
  }

  public function delete(Request $request)
  {
    $material = Material::find($request->id);
    $material->delete();

    return back()->with('success', 'Successfully deleted material');
  }
}
