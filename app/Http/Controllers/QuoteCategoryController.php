<?php

namespace App\Http\Controllers;

use App\QuoteCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class QuoteCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return redirect()->route('quotes.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('quotes.create-category');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!empty($request->file('image'))) {
      $this->validate($request, [
        'name' => 'required',
        'image' => 'required',
      ]);
    } else {
      $this->validate($request, [
        'name' => 'required',
        'image_url' => 'required',
      ]);
    }

    $input = $request->all();

    if (!empty($request->file('image'))) {
      $image = $request->file('image');
      $imageName = 'quoteCategoryImage' . Carbon::now()->format('YmdHis') . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->save(storage_path('app/public/quotes/categories/images/') . $imageName);
      $input['image'] = 'quotes/categories/images/' . $imageName;
    } else {
      $input['image'] = $request->image_url;
    }

    QuoteCategory::create($input);
    return redirect()->route('quotes.index')->with('success', 'Successfully added quote category');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\QuoteCategory  $quoteCategory
   * @return \Illuminate\Http\Response
   */
  public function show(QuoteCategory $quoteCategory)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\QuoteCategory  $quoteCategory
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $quoteCategory = QuoteCategory::find($id);
    return view('quotes.edit-category', compact('quoteCategory'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\QuoteCategory  $quoteCategory
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $quoteCategory = QuoteCategory::find($request->id);
    if (!empty($request->file('image'))) {
      $this->validate($request, [
        'name' => 'required',
        'image' => 'required',
      ]);
    } else {
      $this->validate($request, [
        'name' => 'required',
        'image_url' => 'required',
      ]);
    }

    $input = $request->all();

    if (!empty($request->file('image'))) {

      if (File::exists(storage_path('app/public/' . $quoteCategory->image))) {
        File::delete(storage_path('app/public/' . $quoteCategory->image));
      }

      $image = $request->file('image');
      $imageName = 'quoteCategoryImage' . Carbon::now()->format('YmdHis') . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->save(storage_path('app/public/quotes/categories/images/') . $imageName);
      $input['image'] = 'quotes/categories/images/' . $imageName;
    } else {
      $input['image'] = $request->image_url;
    }

    $quoteCategory->update($input);

    return redirect()->route('quotes.index')->with('success', 'Successfully updated quote category');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\QuoteCategory  $quoteCategory
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $quoteCategory = QuoteCategory::find($id);
    if (File::exists(storage_path('app/public/' . $quoteCategory->image))) {
      File::delete(storage_path('app/public/' . $quoteCategory->image));
    }

    $quoteCategory->delete();
    return back()->with('success', 'Successfully deleted quote category');
  }
}
