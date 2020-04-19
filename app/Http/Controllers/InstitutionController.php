<?php

namespace App\Http\Controllers;

use App\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class InstitutionController extends Controller
{
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
            'image'=> 'mimes:jpg,png,jpeg,JPG',
        ]);

        $input = $request->all();

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $imageName = preg_replace('/\s+/', '', request('name')) . '.' . 'png';
            Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(public_path('storage/institutions/') . $imageName);
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
        return view('institutions.show', compact('institution'));
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
            'image'=> 'mimes:jpg,png,jpeg,JPG',
        ]);

        $input = $request->all();

        if (!empty($request->file('image'))) {
            $image = $request->file('image');
            $imageName = preg_replace('/\s+/', '', request('name')) . '.' . 'png';
            Image::make($image->getRealPath())->encode('png')->fit(300, 300)->save(public_path('storage/institutions/') . $imageName);
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
        if (File::exists(public_path('storage/' . $institution->image))) {
            File::delete(public_path('storage/' . $institution->image));
        }

        $institution->delete();
        return redirect()->route('institutions.index')->with('success', 'Deleted institutions successfully');
    }
}
