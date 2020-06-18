<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'sub_chapter_id', 'order', 'content'
  ];

  public function subChapter()
  {
    return $this->belongsTo(SubChapter::class);
  }
}
