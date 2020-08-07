<?php

namespace App\Http\Controllers;

use App\Quote;
use App\QuoteCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class QuoteController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:quote-list|quote-create|quote-edit|quote-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:quote-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:quote-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:quote-delete', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $quotes = Quote::all();
    $quote_categories = QuoteCategory::all();
    return view('quotes.index', compact('quotes', 'quote_categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $categories = QuoteCategory::pluck('name', 'id')->all();
    return view('quotes.create', compact('categories'));
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
        'quote_category_id' => 'required',
        'quote' => 'required',
        'author' => 'required',
        'image' => 'required'
      ]);
    } else {
      $this->validate($request, [
        'quote_category_id' => 'required',
        'quote' => 'required',
        'author' => 'required',
        'image_url' => 'required'
      ]);
    }

    $input = $request->all();

    if (!empty($request->file('image'))) {
      $image = $request->file('image');
      $imageName = 'quoteImage' . Carbon::now()->format('YmdHis') . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->save(storage_path('app/public/quotes/images/') . $imageName);
      $input['image'] = 'quotes/images/' . $imageName;
    } else {
      $input['image'] = $request->image_url;
    }

    Quote::create($input);

    return redirect()->route('quotes.index')->with('success', 'Successfully added quote');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Quote  $quote
   * @return \Illuminate\Http\Response
   */
  public function show(Quote $quote)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Quote  $quote
   * @return \Illuminate\Http\Response
   */
  public function edit(Quote $quote)
  {
    $categories = QuoteCategory::pluck('name', 'id')->all();
    return view('quotes.edit', compact('quote', 'categories'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Quote  $quote
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Quote $quote)
  {
    if (!empty($request->file('image'))) {
      $this->validate($request, [
        'quote_category_id' => 'required',
        'quote' => 'required',
        'author' => 'required',
        'image' => 'required'
      ]);
    } else {
      $this->validate($request, [
        'quote_category_id' => 'required',
        'quote' => 'required',
        'author' => 'required',
        'image_url' => 'required'
      ]);
    }

    $input = $request->all();

    if (!empty($request->file('image'))) {
      if (File::exists(storage_path('app/public/' . $quote->image))) {
        File::delete(storage_path('app/public/' . $quote->image));
      }
      $image = $request->file('image');
      $imageName = 'quoteImage' . Carbon::now()->format('YmdHis') . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->save(storage_path('app/public/quotes/images/') . $imageName);
      $input['image'] = 'quotes/images/' . $imageName;
    } else {
      $input['image'] = $request->image_url;
    }

    $quote->update($input);

    return redirect()->route('quotes.index')->with('success', 'Successfully updated quote');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Quote  $quote
   * @return \Illuminate\Http\Response
   */
  public function destroy(Quote $quote)
  {
    if (File::exists(storage_path('app/public/' . $quote->image))) {
      File::delete(storage_path('app/public/' . $quote->image));
    }
    $quote->delete();
    return back()->with('success', 'Successfully deleted quote');
  }
}
