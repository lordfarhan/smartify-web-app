<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubChapter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chapter_id', 'sub_chapter', 'title'
    ];
}
