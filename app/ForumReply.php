<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    protected $fillable = [
        'user_id', 'forum_post_id', 'forum_reply_id', 'content', 'attachment'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function forumPost() {
        return $this->belongsTo(ForumPost::class);
    }

    public function forumReply() {
        return $this->belongsTo(ForumReply::class);
    }

    public function forumReplies() {
        return $this->hasMany(ForumReply::class);
    }

}
