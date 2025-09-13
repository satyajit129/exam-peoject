<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreviousExam extends Model
{
    protected $guarded = [];

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'question_previous_exam', // pivot table name
            'exam_id',                // foreign key for PreviousExam
            'question_id'             // foreign key for Question
        );
    }
}

