@extends('layouts.auth')
@section('title', 'Student Login')
@section('content')
<h2 class="auth-title">ចូលប្រើជាសិស្ស</h2>
<p class="auth-sub">សូមបញ្ចូលគណនីសិស្សរបស់អ្នក</p>

@if($errors->any())
    <div class="alert alert-danger py-3 px-4 mb-4" role="alert">
        <i data-lucide="shield-alert"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

<form method="POST" action="/login">
    @csrf
    <div class="mb-4">
        <label class="form-label">អាសយដ្ឋានអ៊ីមែលសិស្ស</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="mail"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@student.com" required autofocus>
        </div>
    </div>
    
    <div class="mb-4">
        <label class="form-label">ពាក្យសម្ងាត់</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="key-round"></i></span>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required id="passwordField">
            <button class="input-group-text pe-3" type="button" onclick="togglePwd()" style="cursor:pointer; background:none;">
                <i data-lucide="eye-off" id="eyeIcon" style="width:18px;height:18px;color:#475569;"></i>
            </button>
        </div>
    </div>

    <div class="mb-5 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <input class="form-check-input mt-0" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">ចងចាំខ្ញុំ</label>
        </div>
        <a href="{{ route('login') }}" class="text-decoration-none" style="color:var(--primary); font-size:0.85rem; font-weight:600;">ចូលជាបុគ្គលិកវិញ?</a>
    </div>

    <button type="submit" class="btn btn-login" style="background: linear-gradient(135deg, #6366f1, #a855f7);">
        <span>ចូលប្រើជាសិស្ស</span>
        <i data-lucide="graduation-cap" style="width:18px;height:18px;"></i>
    </button>
</form>

<script>
function togglePwd() {
    const f = document.getElementById('passwordField');
    const icon = document.getElementById('eyeIcon');
    f.type = f.type === 'password' ? 'text' : 'password';
    icon.setAttribute('data-lucide', f.type === 'password' ? 'eye-off' : 'eye');
    lucide.createIcons();
}
</script>
@endsection
