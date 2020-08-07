<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuoteCategory extends Model
{
  protected $fillable = [
    'name', 'image'
  ];

  public function quotes()
  {
    return $this->hasMany(Quote::class);
  }
}
