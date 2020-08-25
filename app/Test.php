<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
  protected $fillable = [
    'course_id', 'order', 'title', 'type', 'assign', 'description', 'duration'
  ];

  public function course()
  {
    return $this->belongsTo(Course::class, 'course_id');
  }

  public function questions()
  {
    return $this->hasMany(Question::class);
  }

  public function marks()
  {
    return $this->hasMany(Mark::class);
  }
}
