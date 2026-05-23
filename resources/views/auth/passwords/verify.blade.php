@extends('layouts.auth')
@section('title', 'Reset Password — SMS')
@section('content')
<h2 class="auth-title">ភ្លេចពាក្យសម្ងាត់</h2>
<p class="auth-sub">ស្ដារពាក្យសម្ងាត់គណនីរបស់អ្នកឡើងវិញ</p>

@if($errors->any())
    <div class="alert alert-danger py-3 px-4 mb-4" role="alert" style="border-radius: 14px; font-size: 0.85rem;">
        <i data-lucide="shield-alert" style="width: 20px; height: 20px; flex-shrink:0;"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

<form method="POST" action="{{ route('password.self_reset.verify.post') }}">
    @csrf

    <!-- Role Selection Pills -->
    <div class="mb-4">
        <label class="form-label text-center">ជ្រើសរើសតួនាទី / Select Role</label>
        <div class="d-flex p-1 rounded-3 justify-content-between" style="background: var(--input-bg) !important; border: 1px solid var(--input-border);">
            <button type="button" class="btn btn-sm flex-grow-1 py-2 fw-semibold rounded-2 border-0" id="btnStudent" onclick="selectRole('student')" style="font-size:0.82rem; background: var(--primary); color: #fff; transition: all 0.2s;">
                សិស្ស / Student
            </button>
            <button type="button" class="btn btn-sm flex-grow-1 py-2 fw-semibold rounded-2 border-0" id="btnTeacher" onclick="selectRole('teacher')" style="font-size:0.82rem; background: transparent; color: var(--text-sub); transition: all 0.2s;">
                គ្រូ / Teacher
            </button>
        </div>
        <input type="hidden" name="role" id="roleInput" value="student">
    </div>

    <!-- Email Field (Always visible) -->
    <div class="mb-4">
        <label class="form-label" id="emailLabel">អាសយដ្ឋានអ៊ីមែល / Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="mail"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@mail.com" required>
        </div>
    </div>

    <!-- Student ID Field -->
    <div class="mb-4" id="studentIdGroup">
        <label class="form-label">អត្តលេខសិស្ស / Student ID</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="hash"></i></span>
            <input type="text" name="student_id" value="{{ old('student_id') }}" class="form-control" placeholder="STU-XXXX" id="studentIdInput" required>
        </div>
    </div>

    <!-- Teacher ID Field (Hidden by default) -->
    <div class="mb-4 d-none" id="teacherIdGroup">
        <label class="form-label">អត្តលេខគ្រូ / Teacher ID</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="hash"></i></span>
            <input type="text" name="teacher_id" value="{{ old('teacher_id') }}" class="form-control" placeholder="TCH-XXXX" id="teacherIdInput">
        </div>
    </div>

    <!-- Phone Number Field (Visible for student/teacher) -->
    <div class="mb-4" id="phoneGroup">
        <label class="form-label">លេខទូរស័ព្ទ / Phone Number</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="phone"></i></span>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="0XXXXXXXX" id="phoneInput" required>
        </div>
    </div>

    <button type="submit" class="btn btn-login mb-4">
        <span>ផ្ទៀងផ្ទាត់ព័ត៌មាន / Verify</span>
        <i data-lucide="shield-check" style="width:18px;height:18px;"></i>
    </button>

    <div class="text-center">
        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1.5" style="color:var(--text-sub); font-size:0.85rem; transition: color 0.2s;">
            <i data-lucide="arrow-left" style="width:14px; height:14px;"></i>
            <span>ត្រឡប់ទៅចូលប្រព័ន្ធ / Back to Login</span>
        </a>
    </div>
</form>

<script>
function selectRole(role) {
    document.getElementById('roleInput').value = role;
    
    const btnStudent = document.getElementById('btnStudent');
    const btnTeacher = document.getElementById('btnTeacher');
    
    const studentIdGroup = document.getElementById('studentIdGroup');
    const teacherIdGroup = document.getElementById('teacherIdGroup');
    const phoneGroup = document.getElementById('phoneGroup');
    
    const studentIdInput = document.getElementById('studentIdInput');
    const teacherIdInput = document.getElementById('teacherIdInput');
    const phoneInput = document.getElementById('phoneInput');

    // Reset styles
    btnStudent.style.background = 'transparent';
    btnStudent.style.color = 'var(--text-sub)';
    btnTeacher.style.background = 'transparent';
    btnTeacher.style.color = 'var(--text-sub)';

    // Hide all optional fields by default
    studentIdGroup.classList.add('d-none');
    teacherIdGroup.classList.add('d-none');
    phoneGroup.classList.add('d-none');
    
    // Remove required attributes by default
    studentIdInput.removeAttribute('required');
    teacherIdInput.removeAttribute('required');
    phoneInput.removeAttribute('required');

    if (role === 'student') {
        btnStudent.style.background = 'var(--primary)';
        btnStudent.style.color = '#fff';
        
        studentIdGroup.classList.remove('d-none');
        phoneGroup.classList.remove('d-none');
        
        studentIdInput.setAttribute('required', 'required');
        phoneInput.setAttribute('required', 'required');
        
    } else if (role === 'teacher') {
        btnTeacher.style.background = 'var(--primary)';
        btnTeacher.style.color = '#fff';
        
        teacherIdGroup.classList.remove('d-none');
        phoneGroup.classList.remove('d-none');
        
        teacherIdInput.setAttribute('required', 'required');
        phoneInput.setAttribute('required', 'required');
    }
    
    lucide.createIcons();
}

// Keep correct state on redirect back
document.addEventListener('DOMContentLoaded', () => {
    const activeRole = "{{ old('role', 'student') }}";
    selectRole(activeRole);
});
</script>
@endsection
