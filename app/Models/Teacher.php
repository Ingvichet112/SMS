<?php

namespace App\Models;

use Database\Factories\TeacherFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Teacher - គ្រប់គ្រងព័ត៌មានគ្រូ
class Teacher extends Model
{
    use HasFactory;

    // ជួរដែលអនុញ្ញាតឱ្យកំណត់តម្លៃ
    protected $fillable = [
        'teacher_id',
        'name',
        'gender',
        'email',
        'phone',
        'subject',
        'address',
    ];

    // គ្រូ ១ ណែនាំថ្នាក់ច្រើន (One-to-Many)
    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'teacher_id');
    }

    // ឈ្មោះពេញ (Full Name)
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }
}
