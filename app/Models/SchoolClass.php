<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model SchoolClass - គ្រប់គ្រងព័ត៌មានថ្នាក់រៀន
class SchoolClass extends Model
{
    use HasFactory;

    // កំណត់ឈ្មោះតារាង (ព្រោះ Laravel auto ប្រើ school_classes)
    protected $table = 'school_classes';

    // ជួរដែលអនុញ្ញាតឱ្យកំណត់តម្លៃ
    protected $fillable = [
        'class_name',
        'room_number',
        'teacher_id',
    ];

    // ថ្នាក់ ១ ជាកម្មសិទ្ធិគ្រូ ១ (Many-to-One)
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    // ថ្នាក់ ១ មានសិស្សច្រើន (One-to-Many)
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
