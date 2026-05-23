@extends('layouts.app')

@section('title', 'Change Password — Student Management System')
@section('page-title', 'Change Password')

@push('styles')
<style>
    .change-pwd-card {
        background: var(--bs-card-bg, #fff);
        border: 1px solid var(--bs-border-color, #e2e8f0);
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .change-pwd-header {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.06) 0%, rgba(139, 92, 246, 0.06) 100%);
        border-bottom: 1px solid var(--bs-border-color, #e2e8f0);
        padding: 2rem;
    }

    .form-group-custom {
        position: relative;
        margin-bottom: 1.75rem;
    }

    .form-control-custom {
        border-radius: 14px;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        font-size: 0.95rem;
        font-weight: 500;
        border: 1.5px solid var(--bs-border-color, #e2e8f0);
        background-color: var(--bs-body-bg);
        color: var(--bs-body-color);
        transition: all 0.25s ease;
    }

    .form-control-custom:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.12);
        outline: none;
    }

    .form-icon-left {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        transition: color 0.25s ease;
    }

    .form-control-custom:focus ~ .form-icon-left {
        color: #8b5cf6;
    }

    .pwd-toggle-btn {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 8px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pwd-toggle-btn:hover {
        background-color: var(--bs-secondary-bg);
        color: #8b5cf6;
    }

    .pwd-strength-meter {
        height: 6px;
        border-radius: 3px;
        background-color: var(--bs-secondary-bg);
        margin-top: 0.5rem;
        overflow: hidden;
        display: none;
    }

    .pwd-strength-bar {
        height: 100%;
        width: 0;
        border-radius: 3px;
        transition: width 0.3s ease, background-color 0.3s ease;
    }

    .btn-submit-custom {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 14px;
        padding: 0.85rem 2rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
    }

    .btn-submit-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(139, 92, 246, 0.3);
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #fff;
    }

    .btn-cancel-custom {
        border-radius: 14px;
        padding: 0.85rem 1.75rem;
        font-weight: 600;
        border: 1.5px solid var(--bs-border-color, #e2e8f0);
        background-color: transparent;
        color: var(--bs-body-color);
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-cancel-custom:hover {
        background-color: var(--bs-secondary-bg);
        border-color: var(--bs-secondary-bg);
        color: var(--bs-body-color);
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="change-pwd-card">
            <div class="change-pwd-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 56px; height: 56px; flex-shrink: 0;">
                        <i data-lucide="key-round" style="width: 28px; height: 28px;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--bs-body-color);">Change Password</h4>
                        <p class="text-muted mb-0 small" style="font-size: 0.82rem;">ប្តូរពាក្យសម្ងាត់គណនីរបស់អ្នក</p>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4 p-md-5">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert" style="border-radius: 14px;">
                        <i data-lucide="alert-circle" class="lucide-md"></i>
                        <div>
                            <ul class="mb-0 list-unstyled" style="font-size: 0.88rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.change.update') }}">
                    @csrf

                    <!-- Current Password -->
                    <div class="mb-4">
                        <label class="form-label fw-600 mb-2" style="font-size: 0.88rem;">
                            Current Password <span class="text-danger">*</span>
                            <span class="text-muted d-block small" style="font-weight: 400; font-size: 0.76rem;">ពាក្យសម្ងាត់បច្ចុប្បន្ន</span>
                        </label>
                        <div class="form-group-custom">
                            <input type="password" name="current_password" id="currentPassword" class="form-control form-control-custom w-100" placeholder="••••••••" required>
                            <i data-lucide="lock" class="form-icon-left"></i>
                            <button type="button" class="pwd-toggle-btn" onclick="togglePasswordVisibility('currentPassword', 'eyeCurrent')">
                                <i data-lucide="eye-off" id="eyeCurrent" style="width: 18px; height: 18px;"></i>
                            </button>
                        </div>
                    </div>

                    <hr class="my-4" style="opacity: 0.1;">

                    <!-- New Password -->
                    <div class="mb-4">
                        <label class="form-label fw-600 mb-2" style="font-size: 0.88rem;">
                            New Password <span class="text-danger">*</span>
                            <span class="text-muted d-block small" style="font-weight: 400; font-size: 0.76rem;">ពាក្យសម្ងាត់ថ្មី (យ៉ាងហោចណាស់ ៨ ខ្ទង់)</span>
                        </label>
                        <div class="form-group-custom">
                            <input type="password" name="new_password" id="newPassword" class="form-control form-control-custom w-100" placeholder="••••••••" required oninput="checkStrength(this.value)">
                            <i data-lucide="key-round" class="form-icon-left"></i>
                            <button type="button" class="pwd-toggle-btn" onclick="togglePasswordVisibility('newPassword', 'eyeNew')">
                                <i data-lucide="eye-off" id="eyeNew" style="width: 18px; height: 18px;"></i>
                            </button>
                        </div>
                        <!-- Strength Meter -->
                        <div class="pwd-strength-meter" id="strengthMeter">
                            <div class="pwd-strength-bar" id="strengthBar"></div>
                        </div>
                        <small class="text-muted mt-2 d-block" id="strengthText" style="font-size: 0.78rem;"></small>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-4">
                        <label class="form-label fw-600 mb-2" style="font-size: 0.88rem;">
                            Confirm New Password <span class="text-danger">*</span>
                            <span class="text-muted d-block small" style="font-weight: 400; font-size: 0.76rem;">បញ្ជាក់ពាក្យសម្ងាត់ថ្មី</span>
                        </label>
                        <div class="form-group-custom">
                            <input type="password" name="new_password_confirmation" id="newPasswordConfirm" class="form-control form-control-custom w-100" placeholder="••••••••" required>
                            <i data-lucide="check-square" class="form-icon-left"></i>
                            <button type="button" class="pwd-toggle-btn" onclick="togglePasswordVisibility('newPasswordConfirm', 'eyeConfirm')">
                                <i data-lucide="eye-off" id="eyeConfirm" style="width: 18px; height: 18px;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-3 mt-5">
                        <a href="{{ auth()->user()->role === 'student' ? route('student.dashboard') : (auth()->user()->role === 'teacher' ? route('teacher.dashboard') : route('dashboard')) }}" class="btn btn-cancel-custom">
                            Cancel / បោះបង់
                        </a>
                        <button type="submit" class="btn btn-submit-custom d-inline-flex align-items-center gap-2">
                            <span>Change Password / ប្តូរពាក្យសម្ងាត់</span>
                            <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
        
        // Re-render only this icon
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
        
        // Length check
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        
        // Complexity checks
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
@endpush
