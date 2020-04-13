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
        'author_id', 'subject_id', 'grade_id', 'type', 'enrollment_key', 'status', 'status', 'vendor', 'image',
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
        return $this->belongsTo('App\User');
    }

    public function subject() {
        return $this->belongsTo('App\Subject');
    }

    public function grade() {
        return $this->belongsTo('App\Grade');
    }

    public function chapters() {
        return $this->hasMany('App\Chapter')->orderBy('chapter');
    }
}
