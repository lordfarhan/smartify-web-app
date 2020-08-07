<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
  protected $fillable = [
    'quote_category_id', 'quote', 'author', 'image'
  ];

  public function category()
  {
    return $this->belongsTo(QuoteCategory::class, 'quote_category_id');
  }
}
