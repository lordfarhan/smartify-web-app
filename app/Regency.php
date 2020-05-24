<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
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
    
    public function province() {
      return $this->belongsTo(Province::class);
    }

    public function districts() {
      return $this->hasMany(District::class);
    }
}
