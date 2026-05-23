<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'class_id',
        'exam_name',
        'exam_date',
        'start_time',
        'end_time',
        'room',
    ];

    protected $casts = [
        'exam_date' => 'date',
    ];

    // Exam belongs to a Course (Subject)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Exam belongs to a Class
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
