<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
  protected $fillable = [
    'title', 'artist', 'cover', 'url', 'file', 'year', 'license'
  ];
}
