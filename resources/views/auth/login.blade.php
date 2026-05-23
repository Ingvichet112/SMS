@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<h2 class="auth-title">សូមស្វាគមន៍</h2>
<p class="auth-sub">ចូលប្រើប្រាស់ប្រព័ន្ធគ្រប់គ្រងសិស្ស</p>

@if(session('success'))
    <div class="alert alert-success py-3 px-4 mb-4" role="alert" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; border-radius: 14px; font-size: 0.85rem; display: flex; align-items: center; gap: 10px;">
        <i data-lucide="check-circle" style="stroke-width: 2.25;"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger py-3 px-4 mb-4" role="alert">
        <i data-lucide="shield-alert"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

<form method="POST" action="/login">
    @csrf
    <div class="mb-4">
        <label class="form-label">អាសយដ្ឋានអ៊ីមែល</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="user"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="អ៊ីមែលរបស់អ្នក" required autofocus>
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
        <a href="{{ route('password.self_reset.verify') }}" class="text-decoration-none" style="color:var(--primary); font-size:0.85rem; font-weight:600;">ភ្លេចពាក្យសម្ងាត់?</a>
    </div>

    <button type="submit" class="btn btn-login">
        <span>ចូលប្រព័ន្ធ</span>
        <i data-lucide="arrow-right" style="width:18px;height:18px;"></i>
    </button>

    <div class="mt-4 text-center">
        <span style="color: #475569; font-size: 0.85rem;">ឬ</span>
    </div>

    <a href="{{ route('guest') }}" class="btn btn-guest">
        <i data-lucide="user-circle" style="width:20px;height:20px;"></i>
        <span>បន្តជាភ្ញៀវ</span>
    </a>


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
