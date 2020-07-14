<?php

namespace App\Http\Controllers;

use App\Music;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class MusicController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:music-list|music-create|music-edit|music-delete', ['only' => ['index', 'store']]);
    $this->middleware('permission:music-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:music-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:music-delete', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $musics = Music::all();
    return view('musics.index', compact('musics'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('musics.create');
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
      'title' => 'required',
      'artist' => 'required',
      'cover' => 'required',
      'url' => 'required',
      'file' => 'required',
      'year' => 'required',
      'license' => 'required',
    ]);

    $input = $request->all();

    if (!empty($request->file('cover'))) {
      $image = $request->file('cover');
      $coverName = 'musicCover' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', $request->title) . '_' . preg_replace('/\s+/', '', $request->artist) . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->fit(600, 600)->save(storage_path('app/public/musics/covers/') . $coverName);
      $input['cover'] = 'musics/covers/' . $coverName;
    } else {
      $input['cover'] = 'musics/covers/default.png';
    }

    if (!empty($request->file('file'))) {
      $file = $request->file('file');
      $fileName = 'musicFile' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', $request->title) . '_' . preg_replace('/\s+/', '', $request->artist) . '.' . $file->getClientOriginalExtension();
      $file->move(storage_path('app/public/musics/files/'), $fileName);
      $input['file'] = 'musics/files/' . $fileName;
    } else {
      $input['file'] = 'musics/files/default.mp3';
    }

    Music::create($input);
    return redirect()->route('musics.index')->with('success', 'Successfully added music');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Music  $music
   * @return \Illuminate\Http\Response
   */
  public function show(Music $music)
  {
    return view('musics.show', compact('music'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Music  $music
   * @return \Illuminate\Http\Response
   */
  public function edit(Music $music)
  {
    return view('musics.edit', compact('music'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Music  $music
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Music $music)
  {
    $this->validate($request, [
      'title' => 'required',
      'artist' => 'required',
      'url' => 'required',
      'year' => 'required',
      'license' => 'required',
    ]);

    $input = $request->all();

    if (!empty($request->file('cover'))) {
      $image = $request->file('cover');
      $coverName = 'musicCover' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', $request->title) . '_' . preg_replace('/\s+/', '', $request->artist) . '.' . 'png';
      Image::make($image->getRealPath())->encode('png')->fit(600, 600)->save(storage_path('app/public/musics/covers/') . $coverName);
      $input['cover'] = 'musics/covers/' . $coverName;
    } else {
      $input['cover'] = 'musics/covers/default.png';
    }

    if (!empty($request->file('file'))) {
      $file = $request->file('file');
      $fileName = 'musicFile' . Carbon::now()->format('YmdHis') . '_' . preg_replace('/\s+/', '', $request->title) . '_' . preg_replace('/\s+/', '', $request->artist) . '.' . $file->getClientOriginalExtension();
      $file->move(storage_path('app/public/musics/files/'), $fileName);
      $input['file'] = 'musics/files/' . $fileName;
    } else {
      $input['file'] = 'musics/files/default.mp3';
    }

    $music->update($input);

    return redirect()->route('musics.index')->with('success', 'Successfully edited music');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Music  $music
   * @return \Illuminate\Http\Response
   */
  public function destroy(Music $music)
  {
    if (File::exists(storage_path('app/public/' . $music->file))) {
      File::delete(storage_path('app/public/' . $music->file));
    }
    if (File::exists(storage_path('app/public/' . $music->cover))) {
      File::delete(storage_path('app/public/' . $music->cover));
    }
    $music->delete();
    return redirect()->route('musics.index')->with('success', 'Music deleted successfully');
  }
}
