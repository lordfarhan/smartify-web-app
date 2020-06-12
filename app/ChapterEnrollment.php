<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChapterEnrollment extends Model
{
  protected $fillable = [
    'course_enrollment_id', 'chapter_id'
  ];

  public function courseEnrollment()
  {
    return $this->belongsTo(CourseEnrollment::class);
  }

  public function chapter()
  {
    return $this->belongsTo(Chapter::class);
  }

  public function subChapterEnrollments()
  {
    return $this->hasMany(SubChapterEnrollment::class);
  }
}
