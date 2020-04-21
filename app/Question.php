<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'test_id', 'order', 'type', 'question', 'question_image', 'question_audio', 'correct_answer', 'incorrect_answers',
    ];

    public function test() {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
