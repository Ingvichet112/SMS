<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'status',
        'attendance_date',
        'remarks',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    // Attendance belongs to a Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Attendance belongs to a Course (Subject)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
