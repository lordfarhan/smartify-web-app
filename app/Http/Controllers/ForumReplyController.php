<?php

namespace App\Http\Controllers;

use App\ForumReply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ForumReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return route('courses.index');
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
            'user_id' => 'required',
            'forum_post_id' => 'required',
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
                })->save(storage_path('app/public/forum/replies/attachments/') . $attachmentName);
            } else {
                $attachmentName = Carbon::now()->format('YmdHis') . '-' . Str::random() . '.' . $attachment->getClientOriginalExtension();
                $attachment->move(storage_path('app/public/forum/replies/attachments/'), $attachmentName);
            }
            $input['attachment'] = 'forum/replies/attachments/' . $attachmentName;
        } else {
            $input = array_except($input, array('attachment'));
        }

        ForumReply::create($input);

        return back()->with('success', 'Successfully replied');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumReply  $forumReply
     * @return \Illuminate\Http\Response
     */
    public function show(ForumReply $forumReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ForumReply  $forumReply
     * @return \Illuminate\Http\Response
     */
    public function edit(ForumReply $forumReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumReply  $forumReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $forumReply = ForumReply::find($request->id);
        $this->validate($request, [
            'user_id' => 'required',
            'forum_post_id' => 'required',
            'content' => 'required',
            'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,JPG,png',
        ]);

        $input = $request->all();

        if (!empty($request->file('attachment'))) {

            if (File::exists(storage_path('app/public/' . $forumReply->attachment))) {
                File::delete(storage_path('app/public/' . $forumReply->attachment));
            }

            $attachment = $request->file('attachment');
            $attachmentName = '';
            $ext = $request->file('attachment')->getClientOriginalExtension();
            if ($ext == 'jpg' || $ext == 'png') {
                $attachmentName = Carbon::now()->format('YmdHis') . '-' . Str::random() . '.' . 'png';
                Image::make($attachment->getRealPath())->encode('png')->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/forum/replies/attachments/') . $attachmentName);
            } else {
                $attachmentName = Carbon::now()->format('YmdHis') . '-' . Str::random() . '.' . $attachment->getClientOriginalExtension();
                $attachment->move(storage_path('app/public/forum/replies/attachments/'), $attachmentName);
            }
            $input['attachment'] = 'forum/replies/attachments/' . $attachmentName;
        } else {
            $input = array_except($input, array('attachment'));
        }

        $forumReply->update($input);

        return back()->with('success', 'Successfully edited reply');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumReply  $forumReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumReply $forumReply)
    {
        if (File::exists(storage_path('app/public/' . $forumReply->attachment))) {
            File::delete(storage_path('app/public/' . $forumReply->attachment));
        }

        $forumReply->delete();
        return back()->with('success', 'Successfully deleted reply');
    }

    public function delete($course_id, $slug, $reply_id)
    {
        $forumReply = ForumReply::find($reply_id);
        if (File::exists(storage_path('app/public/' . $forumReply->attachment))) {
            File::delete(storage_path('app/public/' . $forumReply->attachment));
        }

        $forumReply->delete();
        return back()->with('success', 'Successfully deleted reply');
    }
}
