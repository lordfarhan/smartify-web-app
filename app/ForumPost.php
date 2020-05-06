<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'slug', 'title', 'content', 'attachment'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function forumReplies() {
        return $this->hasMany(ForumReply::class);
    }
}
