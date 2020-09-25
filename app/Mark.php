<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
  protected $fillable = [
    'user_id', 'test_id', 'attempted', 'number_of_attempts', 'score', 'information'
  ];

  public function test()
  {
    return $this->belongsTo(Test::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
