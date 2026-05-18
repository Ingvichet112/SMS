<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassController;

// -------------------------------------------------------
// ផ្លូវ Authentication (Guest Only)
// -------------------------------------------------------
Route::middleware('guest')->group(function () {
    // ទំព័រ Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Logout (ត្រូវការ auth)
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Redirect ចាប់ផ្ដើម
Route::get('/', function () {
    return redirect()->route('login');
});

// -------------------------------------------------------
// ផ្លូវវ Protected (ត្រូវការ Login)
// -------------------------------------------------------
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Export Routes (ត្រូវតែមុន resource route)
    Route::get('students/export/pdf', [StudentController::class, 'exportPdf'])->name('students.export.pdf');
    Route::get('students/export/excel', [StudentController::class, 'exportExcel'])->name('students.export.excel');

    // Resource Routes
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('classes', ClassController::class);
});
