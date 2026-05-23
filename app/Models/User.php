<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Model User - គ្រប់គ្រងព័ត៌មានអ្នកប្រើប្រាស់
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ជួរដែលអនុញ្ញាតឱ្យកំណត់តម្លៃ
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin, staff, ឬ student
    ];

    // ជួរដែលត្រូវលាក់
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ការដំណើរការប្រភេទទិន្នន័យ
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ពិនិត្យថាតើ User ជា Admin ឬអត់
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ពិនិត្យថាតើ User ជា Student ឬអត់
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    // ពិនិត្យថាតើ User ជា Teacher ឬអត់
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    // ទំនាក់ទំនងទៅ Student
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // ទំនាក់ទំនងទៅ Teacher
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
}
