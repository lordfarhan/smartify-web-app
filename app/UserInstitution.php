<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInstitution extends Model
{
  protected $table = 'user_has_institutions';

  protected $fillable = [
    'user_id', 'institution_id'
  ];

  public function user() {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function institution() {
    return $this->belongsTo(Institution::class, 'institution_id');
  }
}
