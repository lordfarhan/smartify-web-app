<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
  protected $fillable = [
    'user_id', 'course_id', 'rate', 'review'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function course()
  {
    return $this->belongsTo(Course::class);
  }
}
