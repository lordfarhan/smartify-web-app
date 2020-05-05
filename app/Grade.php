<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grade', 'educational_stage', 'information'
    ];

    public function getEducationalStage() {
        if ($this->educational_stage == '0') {
            return 'SD';
        } else if ($this->educational_stage == '1') {
            return 'SMP';
        } else {
            return 'SMA';
        }
    }
}
