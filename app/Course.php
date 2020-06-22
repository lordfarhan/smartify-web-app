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
    'institution_id', 'author_id', 'subject_id', 'grade_id', 'section', 'name', 'type', 'enrollment_key', 'status', 'status', 'vendor', 'image', 'attachment_title', 'attachment'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'enrollment_key',
  ];

  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'institution_id' => 1,
    'image' => 'courses/default.png',
  ];

  protected $appends = ['rating_average', 'reviewer_count'];

  public function institution()
  {
    return $this->belongsTo(Institution::class);
  }

  public function author()
  {
    return $this->belongsTo(User::class);
  }

  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }

  public function grade()
  {
    return $this->belongsTo(Grade::class);
  }

  public function chapters()
  {
    return $this->hasMany(Chapter::class)->orderBy('chapter');
  }

  public function tests()
  {
    return $this->hasMany(Test::class)->orderBy('order');
  }

  public function schedules()
  {
    return $this->hasMany(Schedule::class)->orderBy('date');
  }

  public function enrollments()
  {
    return $this->hasMany(CourseEnrollment::class);
  }

  public function forumPosts()
  {
    return $this->hasMany(ForumPost::class);
  }

  public function reviews()
  {
    return $this->hasMany(CourseReview::class);
  }

  public function getRatingAverageAttribute()
  {
    return $this->reviews()->average('rating') / 10;
  }

  public function getReviewerCountAttribute()
  {
    return $this->reviews()->count('id');
  }
}
