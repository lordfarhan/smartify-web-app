<?php

namespace App\Http\Controllers;

use App\Course;
use App\ForumPost;
use App\Helpers\Slug;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ForumPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        $course = Course::find($course_id);
        return view('forum.create', compact('course'));
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
            'user_id' => 'required',
            'course_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,JPG,png',
        ]);

        $input = $request->all();

        if (!empty($request->file('attachment'))) {
            $attachment = $request->file('attachment');
            $attachmentName = '';
            $ext = $request->file('attachment')->getClientOriginalExtension();
            if ($ext == 'jpg' || $ext == 'png') {
                $attachmentName = Carbon::now()->format('YmdHis') . '-' . Str::random() . '.' . 'png';
                Image::make($attachment->getRealPath())->encode('png')->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/forum/posts/attachments/') . $attachmentName);
            } else {
                $attachmentName = Carbon::now()->format('YmdHis') . '-' . Str::random() . '.' . $attachment->getClientOriginalExtension();
                $attachment->move(storage_path('app/public/forum/posts/attachments/'), $attachmentName);
            }
            $input['attachment'] = 'forum/posts/attachments/' . $attachmentName;
        } else {
            $input = array_except($input, array('attachment'));
        }

        $slug = new Slug();
        $input['slug'] = $slug->createSlug($input['title']);

        ForumPost::create($input);

        return redirect()->route('courses.show', $input['course_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function show($course_id, $slug)
    {
        $forumPost = ForumPost::where('slug', $slug)->firstOrFail();
        return view('forum.show', compact('forumPost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $slug)
    {
        $forumPost = ForumPost::where('slug', $slug)->firstOrFail();
        return view('forum.edit', compact('forumPost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ForumPost $forumPost)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'course_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,JPG,png',
        ]);

        $input = $request->all();

        if (!empty($request->file('attachment'))) {
            
            if (File::exists(storage_path('app/public/' . $forumPost->attachment))) {
                File::delete(storage_path('app/public/' . $forumPost->attachment));
            }

            $attachment = $request->file('attachment');
            $attachmentName = '';
            $ext = $request->file('attachment')->getClientOriginalExtension();
            if ($ext == 'jpg' || $ext == 'png') {
                $attachmentName = Carbon::now()->format('YmdHis') . '-' . Str::random() . '.' . 'png';
                Image::make($attachment->getRealPath())->encode('png')->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/forum/posts/attachments/') . $attachmentName);
            } else {
                $attachmentName = Carbon::now()->format('YmdHis') . '-' . Str::random() . '.' . $attachment->getClientOriginalExtension();
                $attachment->move(storage_path('app/public/forum/posts/attachments/'), $attachmentName);
            }
            $input['attachment'] = 'forum/posts/attachments/' . $attachmentName;
        } else {
            $input = array_except($input, array('attachment'));
        }

        $forumPost->update($input);

        return redirect("courses/{$forumPost->course->id}/forum/{$forumPost->slug}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumPost $forumPost)
    {
        $course_id = $forumPost->course->id;
        if (File::exists(storage_path('app/public/' . $forumPost->attachment))) {
            File::delete(storage_path('app/public/' . $forumPost->attachment));
        }

        $forumPost->delete();

        return redirect()->route('courses.show', $course_id);
    }

    public function delete($course_id, $slug)
    {
        $forumPost = ForumPost::where('slug', $slug)->first();
        if (File::exists(storage_path('app/public/' . $forumPost->attachment))) {
            File::delete(storage_path('app/public/' . $forumPost->attachment));
        }

        $forumPost->delete();

        return redirect()->route('courses.show', $course_id);
    }
}
