<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'subject_id', 'grade_id', 'type', 'enrollment_key', 'status', 'status', 'vendor', 'image', 'attachment_title', 'attachment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'enrollment_key',
    ];

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function grade() {
        return $this->belongsTo(Grade::class);
    }

    public function chapters() {
        return $this->hasMany(Chapter::class)->orderBy('chapter');
    }

    public function schedules() {
        return $this->hasMany(Schedule::class)->orderBy('day');
    }
}
