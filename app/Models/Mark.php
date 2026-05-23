<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'score',
        'semester',
        'academic_year',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // លទ្ធផលនិទ្ទេស (Grade calculation)
    public function getGradeAttribute()
    {
        if ($this->score >= 90) return 'A';
        if ($this->score >= 80) return 'B';
        if ($this->score >= 70) return 'C';
        if ($this->score >= 60) return 'D';
        if ($this->score >= 50) return 'E';
        return 'F';
    }

    // ពណ៌តាមនិទ្ទេស
    public function getGradeColorAttribute()
    {
        return match($this->grade) {
            'A' => '#10b981', // green
            'B' => '#3b82f6', // blue
            'C' => '#f59e0b', // orange
            'D' => '#6366f1', // indigo
            'E' => '#8b5cf6', // purple
            default => '#ef4444', // red
        };
    }
}
