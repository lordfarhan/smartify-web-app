<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'chapter', 'title', 'attachment_title', 'attachment'
    ];

    public function sub_chapters() {
        return $this->hasMany('App\SubChapter');
    }
}
