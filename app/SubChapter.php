<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubChapter extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'chapter_id', 'sub_chapter', 'title'
  ];

  protected $appends = ['finished'];

  public function chapter()
  {
    return $this->belongsTo(Chapter::class);
  }

  public function materials()
  {
    return $this->hasMany(Material::class);
  }

  public function subChapterEnrollment()
  {
    return $this->hasOne(SubChapterEnrollment::class);
  }

  public function getFinishedAttribute()
  {
    if ($this->subChapterEnrollment == null) {
      return 0;
    } else {
      return 1;
    }
  }
}
