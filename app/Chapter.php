<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'course_id', 'chapter', 'title', 'attachment_title', 'attachment'
  ];

  public function subChapters()
  {
    return $this->hasMany(SubChapter::class);
  }

  public function chapterEnrollment()
  {
    return $this->hasOne(ChapterEnrollment::class);
  }
}
