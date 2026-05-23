@extends('layouts.app')

@section('title', 'ការបង់ប្រាក់ — SMS')
@section('page-title', 'ការគ្រប់គ្រងការបង់ប្រាក់')

@push('styles')
<style>
/* Custom local dashboard styles */
.payment-stat-card {
    border-radius: 16px;
    border: none;
    padding: 1.1rem 1.4rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.payment-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
}
.payment-stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem;
    flex-shrink: 0;
}
.payment-stat-label { font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; opacity: .7; }
.payment-stat-value { font-size: 1.5rem; font-weight: 800; line-height: 1.1; }

.inner-sidebar {
    border-right: 1px solid var(--bs-border-color, #e2e8f0);
    background: var(--bs-card-bg, #fff);
    border-radius: 16px 0 0 16px;
}
@media (max-width: 991.98px) {
    .inner-sidebar { border-right: none; border-radius: 16px 16px 0 0; }
}

.student-list-container {
    max-height: 520px;
    overflow-y: auto;
}

/* Custom scrollbar for student list */
.student-list-container::-webkit-scrollbar {
    width: 6px;
}
.student-list-container::-webkit-scrollbar-track {
    background: transparent;
}
.student-list-container::-webkit-scrollbar-thumb {
    background-color: rgba(156, 163, 175, 0.3);
    border-radius: 10px;
}

.student-item {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .85rem 1.1rem;
    border-bottom: 1px solid var(--bs-border-color, #f1f5f9);
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
    color: inherit;
}
.student-item:hover {
    background: var(--bs-secondary-bg, #f8fafc);
}
.student-item.active {
    background: var(--sidebar-active-bg, #f3e8ff);
    border-left: 4px solid var(--sidebar-active-text, #8b5cf6);
    padding-left: calc(1.1rem - 4px);
}
.student-item.active .student-name {
    color: var(--sidebar-active-text, #8b5cf6);
    font-weight: 600;
}

.detail-pane {
    background: var(--bs-card-bg, #fff);
    border-radius: 0 16px 16px 0;
    min-height: 520px;
}
@media (max-width: 991.98px) {
    .detail-pane { border-radius: 0 0 16px 16px; }
}

.pill-tab {
    font-size: .8rem;
    font-weight: 600;
    border-radius: 8px;
    padding: .4rem .8rem;
    border: none;
    background: transparent;
    color: var(--bs-secondary-color);
    transition: all .2s;
}
.pill-tab.active {
    background: var(--bs-primary-bg-subtle, #e0f2fe);
    color: var(--bs-primary, #0284c7);
}

.badge-paid {
    background: #dcfce7;
    color: #15803d;
}
.badge-unpaid {
    background: #fee2e2;
    color: #b91c1c;
}

/* Custom class accordion styling */
.class-accordion .accordion-item {
    background: transparent;
    border: none;
    margin-bottom: 0.5rem;
}
.class-accordion .accordion-button {
    background: var(--bs-secondary-bg, #f8fafc);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 12px !important;
    padding: 0.7rem 1rem;
    font-weight: 600;
    font-size: 0.85rem;
    color: var(--bs-body-color);
    box-shadow: none !important;
    transition: all 0.2s ease;
}
.class-accordion .accordion-button:not(.collapsed) {
    background: var(--bs-secondary-bg, #f1f5f9);
    color: var(--accent, #6366f1);
    border-color: var(--bs-border-color, #cbd5e1);
}
[data-bs-theme="dark"] .class-accordion .accordion-button {
    background: rgba(255,255,255,0.02);
}
[data-bs-theme="dark"] .class-accordion .accordion-button:not(.collapsed) {
    background: rgba(99,102,241,0.15);
    color: #a5b4fc;
}
.class-accordion .accordion-button::after {
    background-size: 0.8rem;
    width: 0.8rem;
    height: 0.8rem;
}
.class-accordion .accordion-body {
    padding: 0.25rem 0 0.5rem 0;
}
.student-sub-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.65rem 1rem 0.65rem 1.5rem;
    border-radius: 10px;
    margin: 0.15rem 0;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    color: inherit;
    border-left: 3px solid transparent;
}
.student-sub-item:hover {
    background: var(--bs-secondary-bg, #f8fafc);
}
.student-sub-item.active {
    background: var(--sidebar-active-bg, #f3e8ff);
    border-left: 3px solid var(--sidebar-active-text, #8b5cf6);
    padding-left: calc(1.5rem - 3px);
}
.student-sub-item.active .student-name {
    color: var(--sidebar-active-text, #8b5cf6);
    font-weight: 600;
}
</style>
@endpush

@section('content')

{{-- 1. Statistics Cards Row --}}
<div class="row g-3 mb-4">
    {{-- Collected --}}
    <div class="col-6 col-md-3">
        <div class="payment-stat-card" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
            <div class="payment-stat-icon" style="background: rgba(16, 185, 129, 0.15);">
                <i data-lucide="check-circle" style="stroke: #10b981; width:22px; height:22px;"></i>
            </div>
            <div>
                <div class="payment-stat-label" style="color: #047857;">បានប្រមូលរួច</div>
                <div class="payment-stat-value" style="color: #064e3b;">${{ number_format($totalCollected, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Pending --}}
    <div class="col-6 col-md-3">
        <div class="payment-stat-card" style="background: linear-gradient(135deg, #fffbeb, #fef3c7);">
            <div class="payment-stat-icon" style="background: rgba(245, 158, 11, 0.15);">
                <i data-lucide="clock" style="stroke: #f59e0b; width:22px; height:22px;"></i>
            </div>
            <div>
                <div class="payment-stat-label" style="color: #b45309;">មិនទាន់ប្រមូល</div>
                <div class="payment-stat-value" style="color: #78350f;">${{ number_format($totalPending, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Paid Count --}}
    <div class="col-6 col-md-3">
        <div class="payment-stat-card" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
            <div class="payment-stat-icon" style="background: rgba(59, 130, 246, 0.15);">
                <i data-lucide="users" style="stroke: #3b82f6; width:22px; height:22px;"></i>
            </div>
            <div>
                <div class="payment-stat-label" style="color: #1d4ed8;">សិស្សបង់រួច</div>
                <div class="payment-stat-value" style="color: #1e3a8a;">{{ $paidCount }} នាក់</div>
            </div>
        </div>
    </div>

    {{-- Unpaid Count --}}
    <div class="col-6 col-md-3">
        <div class="payment-stat-card" style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
            <div class="payment-stat-icon" style="background: rgba(239, 68, 68, 0.15);">
                <i data-lucide="alert-circle" style="stroke: #ef4444; width:22px; height:22px;"></i>
            </div>
            <div>
                <div class="payment-stat-label" style="color: #b91c1c;">សិស្សមិនទាន់បង់</div>
                <div class="payment-stat-value" style="color: #7f1d1d;">{{ $unpaidCount }} នាក់</div>
            </div>
        </div>
    </div>
</div>

{{-- 2. Split Master-Detail Layout --}}
<div class="card border-0 shadow-sm overflow-hidden">
    <div class="row g-0">
        
        {{-- LEFT COLUMN: Inner Sidebar (Student List) --}}
        <div class="col-lg-4 inner-sidebar p-3 d-flex flex-column">
            
            {{-- Search Box --}}
            <form method="GET" action="{{ route('payments.index') }}" class="mb-3" id="paymentSearchForm">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="student" value="{{ $selectedStudent?->id }}">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i data-lucide="search" class="lucide-sm text-muted"></i></span>
                    <input type="text" id="paymentSearchInput" name="search" value="{{ $search }}" class="form-control border-start-0 ps-0" placeholder="ស្វែងរកសិស្ស...">
                    @if($search)
                        <a href="{{ route('payments.index', ['status' => $status, 'student' => $selectedStudent?->id]) }}" class="btn btn-outline-secondary border-start-0"><i data-lucide="x" class="lucide-sm"></i></a>
                    @endif
                </div>
            </form>

            {{-- Tabs for Status Filtering --}}
            <div class="d-flex p-1 rounded-3 mb-3 justify-content-between" style="background: var(--bs-secondary-bg, #f1f5f9);">
                <a href="{{ route('payments.index', ['status' => '', 'search' => $search, 'student' => $selectedStudent?->id]) }}" 
                   class="pill-tab text-center flex-grow-1 text-decoration-none {{ !$status ? 'active' : '' }}">
                    ទាំងអស់
                </a>
                <a href="{{ route('payments.index', ['status' => 'paid', 'search' => $search, 'student' => $selectedStudent?->id]) }}" 
                   class="pill-tab text-center flex-grow-1 text-decoration-none {{ $status === 'paid' ? 'active' : '' }}">
                    <span class="legend-dot me-1" style="background:#10b981; width:7px; height:7px;"></span>បង់រួច
                </a>
                <a href="{{ route('payments.index', ['status' => 'unpaid', 'search' => $search, 'student' => $selectedStudent?->id]) }}" 
                   class="pill-tab text-center flex-grow-1 text-decoration-none {{ $status === 'unpaid' ? 'active' : '' }}">
                    <span class="legend-dot me-1" style="background:#ef4444; width:7px; height:7px;"></span>មិនទាន់បង់
                </a>
            </div>

            {{-- Scrollable Student List Grouped by Class --}}
            <div class="student-list-container flex-grow-1">
                @php
                    $studentsByClass = $students->groupBy(function($student) {
                        return $student->schoolClass?->class_name ?? 'គ្មានថ្នាក់ (Unassigned)';
                    });
                @endphp

                @if($studentsByClass->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i data-lucide="inbox" style="width: 32px; height: 32px; opacity: .4;" class="mb-2"></i>
                        <p class="mb-0" style="font-size: .82rem;">រកមិនឃើញសិស្សទេ</p>
                    </div>
                @else
                    <div class="accordion class-accordion" id="classAccordion">
                        @foreach($studentsByClass as $className => $classStudents)
                            @php
                                $classId = 'class_' . md5($className);
                                $hasActiveStudent = $selectedStudent && $classStudents->contains('id', $selectedStudent->id);
                                $isOpen = $hasActiveStudent || (!$selectedStudent && $loop->first);
                            @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $classId }}">
                                    <button class="accordion-button py-2.5 px-3 {{ $isOpen ? '' : 'collapsed' }}" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse-{{ $classId }}" 
                                            aria-expanded="{{ $isOpen ? 'true' : 'false' }}" 
                                            aria-controls="collapse-{{ $classId }}">
                                        <div class="d-flex align-items-center justify-content-between w-100 pe-3">
                                            <span class="d-flex align-items-center gap-2">
                                                <i data-lucide="building-2" class="text-secondary" style="width: 15px; height: 15px;"></i>
                                                <span>{{ $className }}</span>
                                            </span>
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">{{ $classStudents->count() }} នាក់</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $classId }}" 
                                     class="accordion-collapse collapse {{ $isOpen ? 'show' : '' }}" 
                                     aria-labelledby="heading-{{ $classId }}" 
                                     data-bs-parent="#classAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($classStudents as $student)
                                                @php 
                                                    $studentPaid = $student->payment_status === 'paid';
                                                    $studentActive = $selectedStudent && $selectedStudent->id === $student->id;
                                                @endphp
                                                <a href="{{ route('payments.index', ['status' => $status, 'search' => $search, 'student' => $student->id]) }}" 
                                                   class="student-sub-item {{ $studentActive ? 'active' : '' }}">
                                                    <img src="{{ $student->photo_url }}" alt="" class="avatar-sm flex-shrink-0" style="border-radius: 8px; width: 28px; height: 28px;">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <div class="student-name text-truncate" style="font-size: .82rem; font-weight: 500;">
                                                            {{ $student->full_name }}
                                                        </div>
                                                        <div class="text-muted" style="font-size: .7rem;">
                                                            <code>{{ $student->student_id }}</code>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        @if($studentPaid)
                                                            <span class="badge bg-success-subtle text-success rounded-circle p-1 d-inline-flex" title="Paid">
                                                                <i data-lucide="check" style="width:10px; height:10px; stroke-width:3;"></i>
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger-subtle text-danger rounded-circle p-1 d-inline-flex" title="Unpaid">
                                                                <i data-lucide="alert-circle" style="width:10px; height:10px; stroke-width:3;"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT COLUMN: Details Pane --}}
        <div class="col-lg-8 detail-pane p-4 d-flex flex-column">
            @if($selectedStudent)
                @php 
                    $isPaid = $selectedStudent->payment_status === 'paid';
                    $latestPayment = $selectedStudent->latest_payment;
                @endphp
                
                {{-- Detail Header Profile --}}
                <div class="d-flex align-items-center gap-3 border-bottom pb-4 mb-4 flex-wrap">
                    <img src="{{ $selectedStudent->photo_url }}" alt="" class="avatar-lg rounded-4" style="width: 72px; height: 72px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-1">{{ $selectedStudent->full_name }}</h4>
                        <div class="d-flex align-items-center gap-2.5 flex-wrap text-muted" style="font-size: .85rem;">
                            <span>អត្តលេខ៖ <code>{{ $selectedStudent->student_id }}</code></span>
                            <span>•</span>
                            <span>ថ្នាក់៖ <strong>{{ $selectedStudent->schoolClass?->class_name ?? 'គ្មាន' }}</strong></span>
                            <span>•</span>
                            <span>ភេទ៖ <strong>{{ $selectedStudent->gender }}</strong></span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        @if($isPaid)
                            <span class="badge badge-paid px-3 py-2 rounded-pill fs-7 fw-semibold d-inline-flex align-items-center gap-1.5">
                                <span class="legend-dot" style="background:#15803d; width:8px; height:8px;"></span>
                                បានបង់ប្រាក់រួច (Paid)
                            </span>
                        @else
                            <span class="badge badge-unpaid px-3 py-2 rounded-pill fs-7 fw-semibold d-inline-flex align-items-center gap-1.5">
                                <span class="legend-dot" style="background:#b91c1c; width:8px; height:8px;"></span>
                                មិនទាន់បង់ប្រាក់ (Unpaid)
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Row layout for Payment Control and Info --}}
                <div class="row g-4 mb-4">
                    
                    {{-- Student Contact Information Card --}}
                    <div class="col-md-6">
                        <div class="card h-100 border rounded-4 bg-light-subtle">
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="font-size: .9rem;">
                                    <i data-lucide="user" class="text-primary" style="width:16px; height:16px;"></i>
                                    ព័ត៌មានទំនាក់ទំនងសិស្ស
                                </h6>
                                <div class="d-flex flex-column gap-2 text-muted" style="font-size: .82rem;">
                                    <div class="d-flex justify-content-between">
                                        <span>អ៊ីម៉ែល៖</span>
                                        <span class="text-body fw-medium">{{ $selectedStudent->email ?? '—' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>លេខទូរស័ព្ទ៖</span>
                                        <span class="text-body fw-medium">{{ $selectedStudent->phone ?? '—' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>ថ្ងៃខែឆ្នាំកំណើត៖</span>
                                        <span class="text-body fw-medium">{{ $selectedStudent->date_of_birth ? $selectedStudent->date_of_birth->format('d-M-Y') : '—' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>អាសយដ្ឋាន៖</span>
                                        <span class="text-body fw-medium text-end" style="max-width: 60%;">{{ $selectedStudent->address ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Action Control Card --}}
                    <div class="col-md-6">
                        <div class="card h-100 border rounded-4">
                            <div class="card-body p-3 d-flex flex-column justify-content-center">
                                @if($isPaid)
                                    <div class="text-center py-2">
                                        <div class="badge bg-success-subtle text-success p-3 rounded-circle mb-3">
                                            <i data-lucide="check" style="width: 28px; height: 28px; stroke-width: 2.5;"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">បង់ប្រាក់រួចរាល់!</h6>
                                        <p class="text-muted mb-3" style="font-size: .8rem;">ការបង់ប្រាក់សម្រាប់ឆមាសទី១ ត្រូវបានបញ្ជាក់រួចរាល់។</p>
                                        
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('payments.receipt', $latestPayment) }}" target="_blank" class="btn btn-sm btn-accent rounded-3 px-3">
                                                <i data-lucide="printer" class="lucide-sm me-1.5"></i>បោះពុម្ពវិក្កយបត្រ
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-3"
                                                    onclick="confirmCancelPayment('{{ route('payments.unpaid', $selectedStudent) }}', '{{ $selectedStudent->full_name }}')">
                                                <i data-lucide="x" class="lucide-sm me-1"></i>លុបការបង់
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-2">
                                        <div class="badge bg-danger-subtle text-danger p-3 rounded-circle mb-3">
                                            <i data-lucide="alert-triangle" style="width: 28px; height: 28px;"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">មិនទាន់បង់ប្រាក់</h6>
                                        <p class="text-muted mb-3" style="font-size: .8rem;">មិនទាន់មានទិន្នន័យនៃការបង់ប្រាក់សម្រាប់ឆមាសទី១ ទេ។</p>
                                        
                                        <button type="button" class="btn btn-sm btn-primary rounded-3 px-4 py-2" data-bs-toggle="modal" data-bs-target="#collectPaymentModal">
                                            <i data-lucide="dollar-sign" class="lucide-sm me-1"></i>ប្រមូលប្រាក់ថ្លៃសិក្សា ($150)
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment History Log --}}
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i data-lucide="history" class="text-secondary" style="width:18px; height:18px;"></i>
                        ប្រវត្តិនៃការបង់ប្រាក់ (Payment History)
                    </h6>
                    <div class="table-responsive border rounded-3 overflow-hidden">
                        <table class="table table-hover align-middle mb-0" style="font-size: .84rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">វិក្កយបត្រ ID</th>
                                    <th>ឆមាស</th>
                                    <th>ចំនួនទឹកប្រាក់</th>
                                    <th>កាលបរិច្ឆេទ</th>
                                    <th>វិធីសាស្ត្រ</th>
                                    <th class="pe-3 text-end">សកម្មភាព</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($selectedStudent->payments as $pm)
                                    <tr>
                                        <td class="ps-3"><code>#REC-{{ str_pad($pm->id, 5, '0', STR_PAD_LEFT) }}</code></td>
                                        <td>{{ $pm->semester }}</td>
                                        <td class="fw-bold text-success">${{ number_format($pm->amount, 2) }}</td>
                                        <td class="text-muted">{{ $pm->payment_date ? $pm->payment_date->format('d-M-Y') : '—' }}</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1">{{ $pm->payment_method }}</span>
                                        </td>
                                        <td class="pe-3 text-end">
                                            <a href="{{ route('payments.receipt', $pm) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3 py-0.5 px-2" title="Print Receipt">
                                                <i data-lucide="printer" style="width: 13px; height: 13px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted" style="font-size: .8rem;">
                                            <i data-lucide="info" style="width:18px; height:18px; opacity:.4;" class="mb-1 d-block mx-auto"></i>
                                            មិនទាន់មានប្រវត្តិបង់ប្រាក់ទេ
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Collect Payment Modal --}}
                <div class="modal fade" id="collectPaymentModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4">
                            <div class="modal-header border-bottom-0 pb-0">
                                <h5 class="modal-title fw-bold">កត់ត្រាការបង់ប្រាក់ថ្លៃសិក្សា</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('payments.store', ['status' => $status, 'search' => $search]) }}">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">
                                <div class="modal-body py-3">
                                    <div class="text-center mb-3 py-2 rounded-3" style="background: var(--bs-secondary-bg, #f8f9fa);">
                                        <span class="text-muted d-block" style="font-size:.78rem;">សិស្សត្រូវបង់ប្រាក់</span>
                                        <h5 class="fw-bold mb-0 text-primary">{{ $selectedStudent->full_name }}</h5>
                                        <code style="font-size: .8rem;">{{ $selectedStudent->student_id }} • {{ $selectedStudent->schoolClass?->class_name }}</code>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold" style="font-size:.8rem;">ចំនួនទឹកប្រាក់ (USD)</label>
                                        <div class="input-group">
                                            <span class="input-group-text fw-bold" style="background: var(--bs-secondary-bg, #f8f9fa); color: var(--bs-body-color);">$</span>
                                            <input type="number" step="0.01" name="amount" value="150.00" class="form-control fw-bold" required>
                                        </div>
                                    </div>

                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold" style="font-size:.8rem;">វិធីសាស្ត្របង់ប្រាក់</label>
                                            <select name="payment_method" class="form-select" required>
                                                <option value="ABA">ABA Bank</option>
                                                <option value="Cash">Cash (សាច់ប្រាក់)</option>
                                                <option value="Wing">Wing Pay</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold" style="font-size:.8rem;">កាលបរិច្ឆេទ</label>
                                            <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label fw-semibold" style="font-size:.8rem;">កំណត់សម្គាល់ផ្សេងៗ</label>
                                        <textarea name="remarks" class="form-control" rows="2" placeholder="ឧទាហរណ៍៖ បង់ថ្លៃសិក្សាឆមាសទី១ ពេញ..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-top-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary rounded-3 px-3" data-bs-dismiss="modal">បោះបង់</button>
                                    <button type="submit" class="btn btn-primary rounded-3 px-4"><i data-lucide="check-circle" class="lucide-sm me-1"></i>យល់ព្រម</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @else
                {{-- Empty Detail Panel State --}}
                <div class="d-flex flex-column align-items-center justify-content-center text-center flex-grow-1 text-muted py-5">
                    <div class="badge p-4 rounded-circle mb-3 text-secondary" style="border: 2px dashed var(--bs-border-color); background: var(--bs-secondary-bg, #f8f9fa);">
                        <i data-lucide="banknote" style="width: 48px; height: 48px; opacity: .6;"></i>
                    </div>
                    <h5 class="fw-bold text-body">សូមជ្រើសរើសសិស្ស</h5>
                    <p class="mb-0" style="max-width: 320px; font-size: .85rem;">សូមចុចជ្រើសរើសសិស្សណាម្នាក់ពីបញ្ជីផ្នែកខាងឆ្វេង ដើម្បីមើលប្រវត្តិបង់ប្រាក់ ឬកត់ត្រាការបង់ប្រាក់ថ្លៃសិក្សា។</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- 3. Cancel Payment Confirmation Modal --}}
<div class="modal fade" id="cancelPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body text-center p-4">
                <div class="mb-3 text-danger" style="font-size:3rem;">⚠️</div>
                <h5 class="fw-bold">តើអ្នកចង់លុបការបង់ប្រាក់នេះមែនទេ?</h5>
                <p class="text-muted mb-4" id="cancelStudentName"></p>
                <div class="d-flex gap-3 justify-content-center">
                    <button class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">បោះបង់</button>
                    <form id="cancelPaymentForm" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger rounded-3 px-4"><i data-lucide="trash-2" class="lucide-sm me-1"></i>លុបចោល</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Cancel Payment Confirmation
function confirmCancelPayment(url, name) {
    document.getElementById('cancelPaymentForm').action = url;
    document.getElementById('cancelStudentName').innerHTML = 'ទិន្នន័យនៃការបង់ប្រាក់របស់សិស្ស <strong>' + name + '</strong> នឹងត្រូវបានលុបជាអចិន្ត្រៃ ហើយស្ថានភាពបង់ប្រាក់នឹងត្រូវបានប្ដូរទៅជា <strong>មិនទាន់បង់ប្រាក់</strong> វិញ។';
    new bootstrap.Modal(document.getElementById('cancelPaymentModal')).show();
}

// Auto-submit search when typing pauses
let paymentSearchTimeout;
const searchInput = document.getElementById('paymentSearchInput');
if (searchInput) {
    // Focus search input at the end of the text on reload
    if (searchInput.value) {
        const len = searchInput.value.length;
        searchInput.setSelectionRange(len, len);
        searchInput.focus();
    }
    
    searchInput.addEventListener('input', function() {
        clearTimeout(paymentSearchTimeout);
        paymentSearchTimeout = setTimeout(() => {
            document.getElementById('paymentSearchForm').submit();
        }, 500);
    });
}
</script>
@endpush
