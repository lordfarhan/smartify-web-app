<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubChapterEnrollment extends Model
{
  protected $fillable = [
    'chapter_enrollment_id', 'sub_chapter_id'
  ];

  public function chapterEnrollment()
  {
    return $this->belongsTo(ChapterEnrollment::class);
  }

  public function subChapter()
  {
    return $this->belongsTo(SubChapter::class);
  }
}
