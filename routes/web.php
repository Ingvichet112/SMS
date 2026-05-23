<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\PaymentController;

// -------------------------------------------------------
// ផ្លូវ Authentication (Guest Only)
// -------------------------------------------------------
Route::middleware('guest')->group(function () {
    // ទំព័រ Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Self-service Password Reset routes
    Route::get('/password/reset', [\App\Http\Controllers\Auth\SelfResetPasswordController::class, 'showVerifyForm'])->name('password.self_reset.verify');
    Route::post('/password/reset', [\App\Http\Controllers\Auth\SelfResetPasswordController::class, 'verify'])->name('password.self_reset.verify.post');
    Route::get('/password/reset/new', [\App\Http\Controllers\Auth\SelfResetPasswordController::class, 'showNewPasswordForm'])->name('password.self_reset.new');
    Route::post('/password/reset/new', [\App\Http\Controllers\Auth\SelfResetPasswordController::class, 'reset'])->name('password.self_reset.new.post');

    // បន្តជាភ្ញៀវ
    Route::get('/guest', [DashboardController::class, 'guest'])->name('guest');
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

    // ផ្លាស់ប្តូរពាក្យសម្ងាត់ (Change Password - Self-service)
    Route::get('/password/change', [\App\Http\Controllers\Auth\PasswordController::class, 'edit'])->name('password.change');
    Route::post('/password/change', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.change.update');

    // Dashboard សម្រាប់ Student (រាល់ User ដែលជា Student អាចចូលបាន)
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/student/class', [StudentDashboardController::class, 'myClass'])->name('student.class');
    Route::get('/student/subjects', [StudentDashboardController::class, 'mySubjects'])->name('student.subjects');
    Route::get('/student/exams', [StudentDashboardController::class, 'myExams'])->name('student.exams');
    Route::get('/student/payments', [StudentDashboardController::class, 'myPayments'])->name('student.payments');
    Route::post('/student/payments/pay', [StudentDashboardController::class, 'payTuition'])->name('student.payments.pay');
    Route::get('/student/payments/{payment}/receipt', [StudentDashboardController::class, 'paymentReceipt'])->name('student.payments.receipt');

    // Dashboard សម្រាប់ Teacher (រាល់ User ដែលជា Teacher អាចចូលបាន)
    Route::middleware('teacher')->group(function () {
        Route::get('/teacher/dashboard', [\App\Http\Controllers\TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
        Route::get('/teacher/attendance', [\App\Http\Controllers\TeacherDashboardController::class, 'attendance'])->name('teacher.attendance');
        Route::post('/teacher/attendance', [\App\Http\Controllers\TeacherDashboardController::class, 'storeAttendance'])->name('teacher.attendance.store');
        Route::get('/teacher/attendance/export', [\App\Http\Controllers\TeacherDashboardController::class, 'exportAttendance'])->name('teacher.attendance.export');
        Route::get('/teacher/scores', [\App\Http\Controllers\TeacherDashboardController::class, 'scores'])->name('teacher.scores');
        Route::post('/teacher/scores', [\App\Http\Controllers\TeacherDashboardController::class, 'storeScores'])->name('teacher.scores.store');
        Route::get('/teacher/exams', [\App\Http\Controllers\TeacherDashboardController::class, 'exams'])->name('teacher.exams');
        Route::post('/teacher/exams', [\App\Http\Controllers\TeacherDashboardController::class, 'storeExams'])->name('teacher.exams.store');
        Route::delete('/teacher/exams/{exam}', [\App\Http\Controllers\TeacherDashboardController::class, 'destroyExam'])->name('teacher.exams.destroy');
    });

    // ផ្លូវសម្រាប់តែ Admin/Staff ប៉ុណ្ណោះ
    Route::middleware('admin')->group(function () {
        // Dashboard សម្រាប់ Admin/Staff
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Export Routes
        Route::get('students/export/pdf', [StudentController::class, 'exportPdf'])->name('students.export.pdf');
        Route::get('students/export/excel', [StudentController::class, 'exportExcel'])->name('students.export.excel');

        // Resource Routes
        Route::resource('students', StudentController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('classes', ClassController::class);

        // Payment Routes
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::post('payments/{student}/unpaid', [PaymentController::class, 'markUnpaid'])->name('payments.unpaid');
        Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    });
});
