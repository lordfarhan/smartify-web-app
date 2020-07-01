<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
  /**
   * The "type" of the auto-incrementing ID.
   *
   * @var string
   */
  protected $keyType = 'string';

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;

  public function regency()
  {
    return $this->belongsTo(Regency::class);
  }

  public function villages()
  {
    return $this->hasMany(Village::class)->orderBy('name');
  }
}
