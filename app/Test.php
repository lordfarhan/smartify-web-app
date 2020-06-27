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

  public function marks()
  {
    $this->hasMany(Mark::class);
  }
}
