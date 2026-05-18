@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<h4 class="auth-title">ចូលប្រព័ន្ធ</h4>
<p class="auth-sub">Student Management System</p>
@if($errors->any())
    <div class="alert alert-danger py-2 px-3 mb-3 rounded-3" style="font-size:.85rem;background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.3);color:#fca5a5;">
        <i data-lucide="alert-triangle" style="width:14px;height:14px;"></i> {{ $errors->first() }}
    </div>
@endif
<form method="POST" action="/login">
    @csrf
    <div class="mb-3">
        <label class="form-label">អ៊ីមែល</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="mail"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="admin@sms.com" required autofocus>
        </div>
    </div>
    <div class="mb-4">
        <label class="form-label">ពាក្យសម្ងាត់</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="lock"></i></span>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required id="passwordField">
            <button class="input-group-text" type="button" onclick="togglePwd()" style="cursor:pointer;">
                <i data-lucide="eye" id="eyeIcon"></i>
            </button>
        </div>
    </div>
    <div class="mb-4 d-flex align-items-center gap-2">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);">
        <label class="form-check-label" for="remember" style="color:#94a3b8;font-size:.85rem;">Remember me</label>
    </div>
    <button type="submit" class="btn btn-login w-100">
        <i data-lucide="log-in" style="width:16px;height:16px;margin-right:6px;"></i> ចូលប្រព័ន្ធ
    </button>
</form>
<script>
function togglePwd() {
    const f = document.getElementById('passwordField');
    f.type = f.type === 'password' ? 'text' : 'password';
    document.getElementById('eyeIcon').setAttribute('data-lucide', f.type === 'password' ? 'eye' : 'eye-off');
    lucide.createIcons();
}
</script>
@endsection
