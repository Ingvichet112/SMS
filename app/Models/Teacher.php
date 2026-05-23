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
        'user_id',
        'teacher_id',
        'name',
        'gender',
        'email',
        'phone',
        'subject',
        'address',
        'photo',
    ];

    // ទំនាក់ទំនងទៅ User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
