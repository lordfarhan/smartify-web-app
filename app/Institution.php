<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
  protected $fillable = [
    'name', 'description', 'image'
  ];

  public function courses()
  {
    return $this->hasMany(Course::class);
  }

  public function activationCodes()
  {
    return $this->hasMany(InstitutionActivationCode::class);
  }
}
