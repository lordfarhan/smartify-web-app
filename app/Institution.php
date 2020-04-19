<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = [
        'name', 'description', 'image'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function courses() {
        return $this->hasMany(Course::class);
    }

}
