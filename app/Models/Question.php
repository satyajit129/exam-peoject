<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(QuestionCategory::class, 'category_id');
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function description()
    {
        return $this->hasOne(QuestionDescription::class);
    }

    public function previousExams()
    {
        return $this->belongsToMany(
            PreviousExam::class,
            'question_previous_exam', // pivot table name
            'question_id',            // foreign key for Question
            'exam_id'                 // foreign key for PreviousExam
        )->withTimestamps(); // <- pivot table timestamps auto-fill
    }
    // সঠিক অপশন relation
    public function correctOption()
    {
        return $this->hasOne(QuestionOption::class)->where('is_correct', 1);
    }
}
