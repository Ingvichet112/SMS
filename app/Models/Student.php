<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Student - គ្រប់គ្រងព័ត៌មានសិស្ស
class Student extends Model
{
    use HasFactory;

    // ជួរដែលអនុញ្ញាតឱ្យកំណត់តម្លៃ
    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'email',
        'phone',
        'address',
        'class_id',
        'photo',
    ];

    // ការដំណើរការប្រភេទទិន្នន័យ
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // សិស្ស ១ ជាកម្មសិទ្ធិថ្នាក់ ១ (Many-to-One)
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // ឈ្មោះពេញ (Full Name)
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // URL រូបថតសិស្ស — ប្រើ public/uploads/ ដើម្បីជៀសវាង symlink
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path($this->photo))) {
            return asset($this->photo);
        }
        // រូបលំនាំដើម — ប្រើ UI Avatars API
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=6366f1&color=fff&size=128';
    }

    // អាយុ (Age)
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}
