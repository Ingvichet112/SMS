@extends('layouts.app')

@section('title', 'កាលវិភាគប្រឡងរបស់ខ្ញុំ')
@section('page-title', 'កាលវិភាគប្រឡង')

@push('styles')
<style>
.exam-schedule-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 24px;
    padding: 2.25rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    overflow: hidden;
}
.exam-row-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #f1f5f9);
    border-radius: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.01);
}
.exam-row-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(99, 102, 241, 0.06);
    border-color: rgba(99, 102, 241, 0.2);
}
.exam-badge {
    background: rgba(234, 88, 12, 0.08);
    color: #ea580c;
    font-weight: 700;
    font-size: .8rem;
    padding: .4rem .9rem;
    border-radius: 10px;
    border: 1px solid rgba(234, 88, 12, 0.15);
}
.meta-icon-box {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bs-secondary-bg, #f8fafc);
    color: #64748b;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="exam-schedule-card">
            <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold mb-1" style="color: var(--bs-body-color);"><i data-lucide="calendar-clock" class="me-2 text-primary" style="vertical-align: -3px;"></i> កាលវិភាគប្រឡងផ្លូវការ</h4>
                    <p class="text-muted small mb-0">បញ្ជីពេលវេលា កាលបរិច្ឆេទ និងបន្ទប់ប្រឡងដែលបានកំណត់សម្រាប់ថ្នាក់របស់អ្នក។</p>
                </div>
                <span class="badge bg-primary-subtle text-primary px-3.5 py-2 rounded-pill fw-bold" style="font-size: 0.8rem;">
                    ថ្នាក់៖ {{ auth()->user()->student->schoolClass->class_name ?? 'N/A' }}
                </span>
            </div>

            <div class="row g-4">
                @forelse($exams as $exam)
                    <div class="col-md-6 col-lg-4">
                        <div class="exam-row-card p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="exam-badge">{{ $exam->exam_name }}</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="meta-icon-box" title="បន្ទប់ប្រឡង">
                                            <i data-lucide="map-pin" style="width: 16px; height: 16px;"></i>
                                        </div>
                                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $exam->room ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                
                                <h5 class="fw-bold mb-3 text-dark">{{ $exam->course->course_name }}</h5>
                                <hr class="my-3" style="opacity: 0.08;">

                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <div style="color: #6366f1;">
                                        <i data-lucide="calendar" style="width: 18px; height: 18px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small" style="font-size: 0.72rem;">កាលបរិច្ឆេទប្រឡង</div>
                                        <div class="fw-bold text-dark" style="font-size: 0.88rem;">
                                            {{ $exam->exam_date->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <div style="color: #10b981;">
                                        <i data-lucide="clock" style="width: 18px; height: 18px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small" style="font-size: 0.72rem;">រយៈពេលប្រឡង</div>
                                        <div class="fw-bold text-dark" style="font-size: 0.88rem;">
                                            {{ substr($exam->start_time, 0, 5) }} - {{ substr($exam->end_time, 0, 5) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top d-flex align-items-center justify-content-between" style="border-top: 1px dashed rgba(0,0,0,0.05) !important;">
                                <span class="small text-muted fw-semibold">ស្ថានភាព៖ កំពុងរង់ចាំ</span>
                                <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded-3 fw-bold" style="font-size: 0.7rem;">បានបញ្ជាក់</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center text-muted">
                        <div class="mb-3">
                            <i data-lucide="calendar-x" class="lucide-2xl" style="opacity: 0.2; width: 64px; height: 64px;"></i>
                        </div>
                        <h5 class="fw-bold text-dark">មិនទាន់មានកាលវិភាគប្រឡងឡើយ</h5>
                        <p class="small text-muted mb-0">គ្រូបន្ទុកថ្នាក់មិនទាន់បានកំណត់ពេលវេលាប្រឡងសម្រាប់ថ្នាក់របស់អ្នកនៅឡើយទេ។</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
