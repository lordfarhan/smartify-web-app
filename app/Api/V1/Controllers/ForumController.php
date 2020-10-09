<?php

namespace App\Api\V1\Controllers;

use App\ForumPost;
use App\ForumReply;
use App\Helpers\Slug;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class ForumController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('jwt.auth', []);
  }

  /**
   * API to get forum posts 
   */
  public function getByCourseId(Request $request, $course_id)
  {
    try {
      $posts = ForumPost::where('course_id', $course_id)->get();
      foreach ($posts as $post) {
        $user = User::find($post->user_id);
        $post['user']['id'] = $user->id;
        $post['user']['name'] = $user->name;
        $post['user']['email'] = $user->email;
        $post['user']['phone'] = $user->phone;
        $post['user']['image'] = url('storage/' . $user->image);
        $post['user']['email_verified_at'] = $user->email_verified_at;
        $post['user']['date_of_birth'] = $user->date_of_birth;
        $post['user']['gender'] = $user->gender;
        $post['user']['address'] = $user->address;
        $post['user']['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
        $post['user']['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
        $post['user']['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
        $post['user']['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
        $post['user']['role'] = $user->getRoleNames()[0];
        $post['user']['created_at'] = $user->created_at;
        $post['user']['updated_at'] = $user->updated_at;
        $post['replies'] = ForumReply::where('forum_post_id', $post->id)->whereNull('forum_reply_id')->get();
        foreach ($post['replies'] as $reply) {
          $user = User::find($reply->user_id);
          $reply['user']['id'] = $user->id;
          $reply['user']['name'] = $user->name;
          $reply['user']['email'] = $user->email;
          $reply['user']['phone'] = $user->phone;
          $reply['user']['image'] = url('storage/' . $user->image);
          $reply['user']['email_verified_at'] = $user->email_verified_at;
          $reply['user']['date_of_birth'] = $user->date_of_birth;
          $reply['user']['gender'] = $user->gender;
          $reply['user']['address'] = $user->address;
          $reply['user']['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
          $reply['user']['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
          $reply['user']['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
          $reply['user']['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
          $reply['user']['role'] = $user->getRoleNames()[0];
          $reply['user']['created_at'] = $user->created_at;
          $reply['user']['updated_at'] = $user->updated_at;
          $reply['replies'] = ForumReply::where('forum_reply_id', $reply->id)->get();
          foreach ($reply['replies'] as $childReply) {
            $user = User::find($childReply->user_id);
            $childReply['user']['id'] = $user->id;
            $childReply['user']['name'] = $user->name;
            $childReply['user']['email'] = $user->email;
            $childReply['user']['phone'] = $user->phone;
            $childReply['user']['image'] = url('storage/' . $user->image);
            $childReply['user']['email_verified_at'] = $user->email_verified_at;
            $childReply['user']['date_of_birth'] = $user->date_of_birth;
            $childReply['user']['gender'] = $user->gender;
            $childReply['user']['address'] = $user->address;
            $childReply['user']['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
            $childReply['user']['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
            $childReply['user']['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
            $childReply['user']['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
            $childReply['user']['role'] = $user->getRoleNames()[0];
            $childReply['user']['created_at'] = $user->created_at;
            $childReply['user']['updated_at'] = $user->updated_at;
          }
        }
      }
      return response()->json([
        'success' => true,
        'message' => 'Successfully fetched ',
        'result' => $posts
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function create(Request $request, $course_id)
  {
    $this->validate($request, [
      'title' => 'required',
      'content' => 'required',
      'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,JPG,png',
    ]);
    try {
      $input = $request->all();
      $input['user_id'] = Auth::user()->id;
      $input['course_id'] = $course_id;

      if (!empty($request->file('attachment'))) {
        $attachment = $request->file('attachment');
        $attachmentName = '';
        $ext = $request->file('attachment')->getClientOriginalExtension();
        if ($ext == 'jpg' || $ext == 'png') {
          $attachmentName = 'forumAttachment' . Carbon::now()->format('YmdHis') . '_' . $request->input('user_id') . '_' . Str::random() . '.' . 'png';
          Image::make($attachment->getRealPath())->encode('png')->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
          })->save(storage_path('app/public/forum/posts/attachments/') . $attachmentName);
        } else {
          $attachmentName = 'forumAttachment' . Carbon::now()->format('YmdHis') . '_' . $request->input('user_id') . '_' . Str::random() . '.' . $attachment->getClientOriginalExtension();
          $attachment->move(storage_path('app/public/forum/posts/attachments/'), $attachmentName);
        }
        $input['attachment'] = 'forum/posts/attachments/' . $attachmentName;
      } else {
        $input = array_except($input, array('attachment'));
      }

      $slug = new Slug();
      $input['slug'] = $slug->createSlug($input['title']);

      $post = ForumPost::create($input);
      $user = User::find($post->user_id);
      $post['user']['id'] = $user->id;
      $post['user']['name'] = $user->name;
      $post['user']['email'] = $user->email;
      $post['user']['phone'] = $user->phone;
      $post['user']['image'] = url('storage/' . $user->image);
      $post['user']['email_verified_at'] = $user->email_verified_at;
      $post['user']['date_of_birth'] = $user->date_of_birth;
      $post['user']['gender'] = $user->gender;
      $post['user']['address'] = $user->address;
      $post['user']['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
      $post['user']['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
      $post['user']['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
      $post['user']['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
      $post['user']['role'] = $user->getRoleNames()[0];
      $post['user']['created_at'] = $user->created_at;
      $post['user']['updated_at'] = $user->updated_at;
      $post['replies'] = ForumReply::where('forum_post_id', $post->id)->whereNull('forum_reply_id')->get();

      return response()->json([
        'success' => true,
        'message' => 'Successfully posted to forum.',
        'result' => [
          $post
        ]
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function update(Request $request, $course_id, $id)
  {
    $this->validate($request, [
      'title' => 'required',
      'content' => 'required',
      'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,JPG,png',
    ]);

    try {
      $forumPost = ForumPost::find($id);

      if ($forumPost->user_id != Auth::user()->id) {
        return response()->json([
          'success' => false,
          'message' => 'Forbidden, you are not allowed to update the post that not yours.',
          'result' => null
        ], 403);
      }

      $input = $request->all();

      if (!empty($request->file('attachment'))) {

        if (File::exists(storage_path('app/public/' . $forumPost->attachment))) {
          File::delete(storage_path('app/public/' . $forumPost->attachment));
        }

        $attachment = $request->file('attachment');
        $attachmentName = '';
        $ext = $request->file('attachment')->getClientOriginalExtension();
        if ($ext == 'jpg' || $ext == 'png') {
          $attachmentName = 'forumAttachment' . Carbon::now()->format('YmdHis') . '_' . $request->input('user_id') . '_' . Str::random() . '.' . 'png';
          Image::make($attachment->getRealPath())->encode('png')->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
          })->save(storage_path('app/public/forum/posts/attachments/') . $attachmentName);
        } else {
          $attachmentName = 'forumAttachment' . Carbon::now()->format('YmdHis') . '_' . $request->input('user_id') . '_' . Str::random() . '.' . $attachment->getClientOriginalExtension();
          $attachment->move(storage_path('app/public/forum/posts/attachments/'), $attachmentName);
        }
        $input['attachment'] = 'forum/posts/attachments/' . $attachmentName;
      } else {
        $input = array_except($input, array('attachment'));
      }

      $forumPost->update($input);
      $user = User::find($forumPost->user_id);
      $forumPost['user']['id'] = $user->id;
      $forumPost['user']['name'] = $user->name;
      $forumPost['user']['email'] = $user->email;
      $forumPost['user']['phone'] = $user->phone;
      $forumPost['user']['image'] = url('storage/' . $user->image);
      $forumPost['user']['email_verified_at'] = $user->email_verified_at;
      $forumPost['user']['date_of_birth'] = $user->date_of_birth;
      $forumPost['user']['gender'] = $user->gender;
      $forumPost['user']['address'] = $user->address;
      $forumPost['user']['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
      $forumPost['user']['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
      $forumPost['user']['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
      $forumPost['user']['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
      $forumPost['user']['role'] = $user->getRoleNames()[0];
      $forumPost['user']['created_at'] = $user->created_at;
      $forumPost['user']['updated_at'] = $user->updated_at;
      $forumPost['replies'] = ForumReply::where('forum_post_id', $forumPost->id)->whereNull('forum_reply_id')->get();

      return response()->json([
        'success' => true,
        'message' => 'Successfully updated post.',
        'result' => [
          $forumPost
        ]
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function delete(Request $request, $course_id, $id)
  {
    try {
      $forumPost = ForumPost::find($id);

      if ($forumPost->user_id != Auth::user()->id) {
        return response()->json([
          'success' => false,
          'message' => 'Forbidden, you are not allowed to delete the post that not yours.',
          'result' => null
        ], 403);
      }

      if (File::exists(storage_path('app/public/' . $forumPost->attachment))) {
        File::delete(storage_path('app/public/' . $forumPost->attachment));
      }

      $forumPost->delete();

      return response()->json([
        'success' => true,
        'message' => 'Successfully deleted post.',
        'result' => null
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function reply(Request $request, $course_id, $forum_post_id)
  {
    $this->validate($request, [
      'content' => 'required',
      'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,JPG,png',
    ]);

    try {
      $input = $request->all();
      $input['user_id'] = Auth::user()->id;
      $input['forum_post_id'] = $forum_post_id;

      if (!empty($request->file('attachment'))) {
        $attachment = $request->file('attachment');
        $attachmentName = '';
        $ext = $request->file('attachment')->getClientOriginalExtension();
        if ($ext == 'jpg' || $ext == 'png') {
          $attachmentName = 'forumReplyAttachment' . Carbon::now()->format('YmdHis') . '_' . $request->input('user_id') . '_' . Str::random() . '.' . 'png';
          Image::make($attachment->getRealPath())->encode('png')->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
          })->save(storage_path('app/public/forum/replies/attachments/') . $attachmentName);
        } else {
          $attachmentName = 'forumReplyAttachment' . Carbon::now()->format('YmdHis') . '_' . $request->input('user_id') . '_' . Str::random() . '.' . $attachment->getClientOriginalExtension();
          $attachment->move(storage_path('app/public/forum/replies/attachments/'), $attachmentName);
        }
        $input['attachment'] = 'forum/replies/attachments/' . $attachmentName;
      } else {
        $input = array_except($input, array('attachment'));
      }

      $reply = ForumReply::create($input);
      $user = User::find($reply->user_id);
      $reply['user']['id'] = $user->id;
      $reply['user']['name'] = $user->name;
      $reply['user']['email'] = $user->email;
      $reply['user']['phone'] = $user->phone;
      $reply['user']['image'] = url('storage/' . $user->image);
      $reply['user']['email_verified_at'] = $user->email_verified_at;
      $reply['user']['date_of_birth'] = $user->date_of_birth;
      $reply['user']['gender'] = $user->gender;
      $reply['user']['address'] = $user->address;
      $reply['user']['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
      $reply['user']['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
      $reply['user']['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
      $reply['user']['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
      $reply['user']['role'] = $user->getRoleNames()[0];
      $reply['user']['created_at'] = $user->created_at;
      $reply['user']['updated_at'] = $user->updated_at;
      $reply['replies'] = ForumReply::where('forum_reply_id', $reply->id)->get();

      return response()->json([
        'success' => true,
        'message' => 'Successfully replied to forum.',
        'result' => [
          $reply
        ]
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function updateReply(Request $request, $course_id, $forum_post_id, $id)
  {
    $this->validate($request, [
      'content' => 'required',
      'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,JPG,png',
    ]);

    try {
      $forumReply = ForumReply::find($id);

      if ($forumReply->user_id != Auth::user()->id) {
        return response()->json([
          'success' => false,
          'message' => 'Forbidden, you are not allowed to update the reply that not yours.',
          'result' => null
        ], 403);
      }

      $input = $request->all();
      $input['user_id'] = Auth::user()->id;
      $input['forum_post_id'] = $forum_post_id;

      if (!empty($request->file('attachment'))) {

        if (File::exists(storage_path('app/public/' . $forumReply->attachment))) {
          File::delete(storage_path('app/public/' . $forumReply->attachment));
        }

        $attachment = $request->file('attachment');
        $attachmentName = '';
        $ext = $request->file('attachment')->getClientOriginalExtension();
        if ($ext == 'jpg' || $ext == 'png') {
          $attachmentName = 'forumReplyAttachment' . Carbon::now()->format('YmdHis') . '_' . $request->input('user_id') . '_' . Str::random() . '.' . 'png';
          Image::make($attachment->getRealPath())->encode('png')->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
          })->save(storage_path('app/public/forum/replies/attachments/') . $attachmentName);
        } else {
          $attachmentName = 'forumReplyAttachment' . Carbon::now()->format('YmdHis') . '_' . $request->input('user_id') . '_' . Str::random() . '.' . $attachment->getClientOriginalExtension();
          $attachment->move(storage_path('app/public/forum/replies/attachments/'), $attachmentName);
        }
        $input['attachment'] = 'forum/replies/attachments/' . $attachmentName;
      } else {
        $input = array_except($input, array('attachment'));
      }

      $forumReply->update($input);
      $user = User::find($forumReply->user_id);
      $forumReply['user']['id'] = $user->id;
      $forumReply['user']['name'] = $user->name;
      $forumReply['user']['email'] = $user->email;
      $forumReply['user']['phone'] = $user->phone;
      $forumReply['user']['image'] = url('storage/' . $user->image);
      $forumReply['user']['email_verified_at'] = $user->email_verified_at;
      $forumReply['user']['date_of_birth'] = $user->date_of_birth;
      $forumReply['user']['gender'] = $user->gender;
      $forumReply['user']['address'] = $user->address;
      $forumReply['user']['village'] = $user->village != null ? ucwords(strtolower($user->village->name)) : null;
      $forumReply['user']['district'] = $user->village != null ? ucwords(strtolower($user->village->district->name)) : null;
      $forumReply['user']['regency'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->name)) : null;
      $forumReply['user']['province'] = $user->village != null ? ucwords(strtolower($user->village->district->regency->province->name)) : null;
      $forumReply['user']['role'] = $user->getRoleNames()[0];
      $forumReply['user']['created_at'] = $user->created_at;
      $forumReply['user']['updated_at'] = $user->updated_at;
      $forumReply['replies'] = ForumReply::where('forum_reply_id', $forumReply->id)->get();

      return response()->json([
        'success' => true,
        'message' => 'Successfully updated reply.',
        'result' => [
          $forumReply
        ]
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }

  public function deleteReply(Request $request, $course_id, $forum_post_id, $id)
  {
    try {
      $forumReply = ForumReply::find($id);

      if ($forumReply->user_id != Auth::user()->id) {
        return response()->json([
          'success' => false,
          'message' => 'Forbidden, you are not allowed to delete the reply that not yours.',
          'result' => null
        ], 403);
      }

      if (File::exists(storage_path('app/public/' . $forumReply->attachment))) {
        File::delete(storage_path('app/public/' . $forumReply->attachment));
      }

      $forumReply->delete();
      return response()->json([
        'success' => true,
        'message' => 'Successfully deleted reply.',
        'result' => null
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
        'result' => null
      ], 500);
    }
  }
}
