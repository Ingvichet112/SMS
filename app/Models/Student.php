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
        'user_id',
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

    // សិស្ស ១ អាចមាន User account ១
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // សិស្ស ១ ជាកម្មសិទ្ធិថ្នាក់ ១ (Many-to-One)
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // សិស្ស ១ មានពិន្ទុច្រើន
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    // សិស្ស ១ មានការបង់ប្រាក់ច្រើន
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // សិស្ស ១ មានវត្តមានច្រើន
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // ពិនិត្យស្ថានភាពបង់ប្រាក់បច្ចុប្បន្ន (បង់រួច ឬ មិនទាន់បង់)
    public function getPaymentStatusAttribute(): string
    {
        $latest = $this->payments()->where('semester', 'Semester 1')->where('status', 'paid')->first();
        return $latest ? 'paid' : 'unpaid';
    }

    // ទទួលបានការបង់ប្រាក់ចុងក្រោយបង្អស់
    public function getLatestPaymentAttribute()
    {
        return $this->payments()->latest()->first();
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
