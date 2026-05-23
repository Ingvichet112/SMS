@extends('layouts.auth')
@section('title', 'Choose New Password — SMS')
@section('content')
<h2 class="auth-title">ពាក្យសម្ងាត់ថ្មី</h2>
<p class="auth-sub">កំណត់ពាក្យសម្ងាត់ថ្មីសម្រាប់គណនីរបស់អ្នក</p>

@if($errors->any())
    <div class="alert alert-danger py-3 px-4 mb-4" role="alert" style="border-radius: 14px; font-size: 0.85rem;">
        <i data-lucide="shield-alert" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

<form method="POST" action="{{ route('password.self_reset.new.post') }}">
    @csrf

    <!-- New Password -->
    <div class="mb-4">
        <label class="form-label">ពាក្យសម្ងាត់ថ្មី / New Password</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="key-round"></i></span>
            <input type="password" name="password" id="newPassword" class="form-control" placeholder="••••••••" required oninput="checkStrength(this.value)" autofocus>
            <button class="input-group-text pe-3" type="button" onclick="togglePasswordVisibility('newPassword', 'eyeNew')" style="cursor:pointer; background:none; border:none;">
                <i data-lucide="eye-off" id="eyeNew" style="width:18px;height:18px;color:var(--text-sub);"></i>
            </button>
        </div>
        <!-- Strength Meter -->
        <div id="strengthMeter" style="height: 5px; border-radius: 3px; background-color: var(--input-border); margin-top: 0.5rem; overflow: hidden; display: none;">
            <div id="strengthBar" style="height: 100%; width: 0; transition: width 0.3s ease, background-color 0.3s ease;"></div>
        </div>
        <small class="mt-2 d-block" id="strengthText" style="font-size: 0.78rem;"></small>
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label class="form-label">បញ្ជាក់ពាក្យសម្ងាត់ថ្មី / Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text"><i data-lucide="check-square"></i></span>
            <input type="password" name="password_confirmation" id="newPasswordConfirm" class="form-control" placeholder="••••••••" required>
            <button class="input-group-text pe-3" type="button" onclick="togglePasswordVisibility('newPasswordConfirm', 'eyeConfirm')" style="cursor:pointer; background:none; border:none;">
                <i data-lucide="eye-off" id="eyeConfirm" style="width:18px;height:18px;color:var(--text-sub);"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn-login mb-4">
        <span>រក្សាទុកពាក្យសម្ងាត់ / Save Password</span>
        <i data-lucide="save" style="width:18px;height:18px;"></i>
    </button>
</form>

<script>
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.setAttribute('data-lucide', 'eye');
    } else {
        input.type = 'password';
        icon.setAttribute('data-lucide', 'eye-off');
    }
    lucide.createIcons();
}

function checkStrength(password) {
    const meter = document.getElementById('strengthMeter');
    const bar = document.getElementById('strengthBar');
    const text = document.getElementById('strengthText');
    
    if (password.length === 0) {
        meter.style.display = 'none';
        text.innerHTML = '';
        return;
    }
    
    meter.style.display = 'block';
    let score = 0;
    
    if (password.length >= 8) score++;
    if (password.length >= 12) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;
    
    let width = '20%';
    let color = '#ef4444'; // Red
    let label = 'Weak / ខ្សោយ';
    
    if (score >= 4) {
        width = '100%';
        color = '#22c55e'; // Green
        label = 'Strong / ខ្លាំង';
    } else if (score >= 2) {
        width = '60%';
        color = '#f59e0b'; // Amber
        label = 'Medium / មធ្យម';
    }
    
    bar.style.width = width;
    bar.style.backgroundColor = color;
    text.innerHTML = `<span style="color: ${color}; font-weight: 600;">Password strength: ${label}</span>`;
}
</script>
@endsection
