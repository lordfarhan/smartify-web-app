<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitutionActivationCode extends Model
{
  protected $fillable = [
    'institution_id', 'user_id', 'code'
  ];

  public function institution()
  {
    return $this->belongsTo(Institution::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
