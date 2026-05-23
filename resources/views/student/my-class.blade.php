@extends('layouts.app')
@section('title', 'My Class')
@section('page-title', 'Class Information')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header py-3 px-4 bg-primary bg-opacity-10">
                <h6 class="mb-0 fw-bold text-primary"><i data-lucide="info" class="lucide-sm me-2"></i>ព័ត៌មានលម្អិតថ្នាក់</h6>
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 80px; height: 80px;">
                        <i data-lucide="building-2" style="width: 40px; height: 40px;"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $class->class_name }}</h4>
                    <span class="badge text-muted px-3 py-2 rounded-pill border" style="background-color: var(--bs-secondary-bg);">បន្ទប់៖ {{ $class->room_number ?? 'N/A' }}</span>
                </div>

                <div class="pt-3 border-top">
                    <div class="small text-muted mb-2 text-uppercase fw-bold letter-spacing-1">គ្រូបន្ទុកថ្នាក់</div>
                    @if($class->teacher)
                        <div class="d-flex align-items-center gap-3">
                            @if(!empty($class->teacher->photo))
                                <img src="{{ asset($class->teacher->photo) }}" alt="Teacher Profile" style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                            @else
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1rem; box-shadow: 0 4px 10px rgba(16,185,129,0.15);">
                                    {{ strtoupper(substr($class->teacher->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $class->teacher->name }}</div>
                                <div class="small text-muted">{{ $class->teacher->subject ?? 'អប់រំទូទៅ' }}</div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #ef4444, #dc2626); display: flex; align-items: center; justify-content: center; color: #fff;">
                                <i data-lucide="user-x"></i>
                            </div>
                            <div>
                                <div class="fw-bold">មិនទាន់ចាត់ចែង</div>
                                <div class="small text-muted">—</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i data-lucide="users" class="lucide-sm me-2"></i>មិត្តរួមថ្នាក់របស់ខ្ញុំ</h6>
                <span class="badge bg-primary rounded-pill">{{ $class->students->count() }} សិស្ស</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: var(--bs-tertiary-bg);">
                            <tr>
                                <th class="ps-4">សិស្ស</th>
                                <th>ភេទ</th>
                                <th class="text-end pe-4">អត្តលេខសិស្ស</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $classmate)
                            <tr class="{{ $classmate->id === $student->id ? 'table-active' : '' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $classmate->photo_url }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;" alt="">
                                        <span class="fw-500">{{ $classmate->full_name }}</span>
                                        @if($classmate->id === $student->id)
                                            <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-10 ms-1" style="font-size: .65rem;">ខ្លួនអ្នក</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $classmate->gender === 'Male' ? 'ប្រុស' : ($classmate->gender === 'Female' ? 'ស្រី' : $classmate->gender) }}</td>
                                <td class="text-end pe-4 text-muted small">#{{ $classmate->student_id }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
