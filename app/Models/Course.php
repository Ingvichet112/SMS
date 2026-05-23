<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Course - គ្រប់គ្រងព័ត៌មានមុខវិជ្ជា
class Course extends Model
{
    use HasFactory;

    // ជួរដែលអនុញ្ញាតឱ្យកំណត់តម្លៃ
    protected $fillable = [
        'course_code',
        'course_name',
        'description',
        'credit',
    ];

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
