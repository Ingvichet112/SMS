@extends('layouts.app')
@section('title', 'មុខវិជ្ជា និងពិន្ទុរបស់ខ្ញុំ')
@section('page-title', 'លទ្ធផលសិក្សារបស់ខ្ញុំ')

@push('styles')
<style>
.subject-card {
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    background: var(--bs-card-bg, #fff);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
.subject-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
    border-color: var(--accent, #6366f1);
}
.subject-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: all 0.3s ease;
}
.subject-card:hover .subject-icon-wrap {
    transform: scale(1.1) rotate(5deg);
}
.grade-badge-circle {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 800;
    line-height: 1;
}
.progress-bar-animated-smooth {
    height: 8px;
    border-radius: 8px;
    background: var(--bs-secondary-bg, #f1f5f9);
    overflow: hidden;
}
.progress-fill-gradient {
    height: 100%;
    border-radius: 8px;
    transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.subject-meta-box {
    background: var(--bs-secondary-bg, #f8fafc);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 12px;
    padding: 0.6rem;
}
[data-bs-theme="dark"] .subject-meta-box {
    background: rgba(255, 255, 255, 0.02);
}
</style>
@endpush

@section('content')
<div class="row g-4">
    @forelse($subjects as $subject)
    @php
        $mark = $subject->marks->first();
        
        // Dynamic Lucide icons based on subject name
        $subjectName = strtolower($subject->course_name);
        $icon = 'graduation-cap';
        $iconBg = 'rgba(99, 102, 241, 0.1)';
        $iconColor = '#6366f1';
        
        if (str_contains($subjectName, 'math') || str_contains($subjectName, 'គណិត')) {
            $icon = 'calculator';
            $iconBg = 'rgba(59, 130, 246, 0.1)';
            $iconColor = '#3b82f6';
        } elseif (str_contains($subjectName, 'english') || str_contains($subjectName, 'អង់គ្លេស')) {
            $icon = 'languages';
            $iconBg = 'rgba(16, 185, 129, 0.1)';
            $iconColor = '#10b981';
        } elseif (str_contains($subjectName, 'science') || str_contains($subjectName, 'វិទ្យាសាស្ត្រ')) {
            $icon = 'beaker';
            $iconBg = 'rgba(239, 68, 68, 0.1)';
            $iconColor = '#ef4444';
        } elseif (str_contains($subjectName, 'khmer') || str_contains($subjectName, 'ខ្មែរ')) {
            $icon = 'book-open';
            $iconBg = 'rgba(139, 92, 246, 0.1)';
            $iconColor = '#8b5cf6';
        } elseif (str_contains($subjectName, 'physics') || str_contains($subjectName, 'រូប')) {
            $icon = 'atom';
            $iconBg = 'rgba(245, 158, 11, 0.1)';
            $iconColor = '#f59e0b';
        } elseif (str_contains($subjectName, 'chemistry') || str_contains($subjectName, 'គីមី')) {
            $icon = 'flask-conical';
            $iconBg = 'rgba(20, 184, 166, 0.1)';
            $iconColor = '#14b8a6';
        } elseif (str_contains($subjectName, 'computer') || str_contains($subjectName, 'ព័ត៌មាន')) {
            $icon = 'cpu';
            $iconBg = 'rgba(100, 116, 139, 0.1)';
            $iconColor = '#64748b';
        }
    @endphp
    <div class="col-md-6 col-xl-4">
        <div class="subject-card h-100 d-flex flex-column">
            
            {{-- Top Header Section --}}
            <div class="p-4 pb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="subject-icon-wrap" style="background: {{ $iconBg }}; color: {{ $iconColor }};">
                        <i data-lucide="{{ $icon }}"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-truncate" style="max-width: 170px; font-size: 1rem;">{{ $subject->course_name }}</h6>
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1 mt-1" style="font-size: 0.68rem; font-weight: 600;">
                            {{ $subject->credit }} ក្រេឌីត
                        </span>
                    </div>
                </div>
                <code class="small text-secondary fw-semibold bg-secondary-subtle px-2 py-1 rounded">{{ $subject->course_code }}</code>
            </div>
            
            {{-- Middle Score Performance Section --}}
            <div class="card-body px-4 py-3 flex-grow-1 d-flex flex-column justify-content-center">
                @if($mark)
                    @php
                        $hex = str_replace('#', '', $mark->grade_color);
                        $r = hexdec(substr($hex, 0, 2));
                        $g = hexdec(substr($hex, 2, 2));
                        $b = hexdec(substr($hex, 4, 2));
                        $rgbaColor = "rgba($r, $g, $b, 0.12)";
                    @endphp
                    <div class="d-flex align-items-center justify-content-between mb-3 bg-light-subtle p-3 rounded-4 border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="grade-badge-circle" style="background: {{ $rgbaColor }}; color: {{ $mark->grade_color }};">
                                {{ $mark->grade }}
                            </div>
                            <div>
                                <div class="small text-muted fw-semibold">និទ្ទេសទទួលបាន</div>
                                <div class="fw-bold text-body" style="font-size: 1.15rem;">{{ $mark->score }} <span class="text-muted" style="font-size: 0.8rem; font-weight: 500;">/ 100</span></div>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge rounded-pill text-uppercase px-2.5 py-1 font-semibold" style="background: {{ $rgbaColor }}; color: {{ $mark->grade_color }}; font-size: 0.65rem;">
                                {{ $mark->score >= 50 ? 'ជាប់' : 'ធ្លាក់' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="progress-bar-animated-smooth">
                            <div class="progress-fill-gradient" style="width: {{ $mark->score }}%; background: linear-gradient(90deg, {{ $mark->grade_color }}dd, {{ $mark->grade_color }});"></div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 px-3 rounded-4 bg-light bg-opacity-50 border border-dashed mb-3 d-flex flex-column align-items-center justify-content-center flex-grow-1">
                        <i data-lucide="info" class="text-muted mb-2" style="width: 22px; height: 22px; opacity: 0.5;"></i>
                        <div class="fw-bold text-muted" style="font-size: 0.82rem;">មិនទាន់មានលទ្ធផលពិន្ទុ</div>
                        <div class="small text-muted" style="font-size: 0.72rem; max-width: 180px; margin-top: 2px;">ពិន្ទុរបស់អ្នកសម្រាប់មុខវិជ្ជានេះកំពុងស្ថិតក្នុងការរង់ចាំ។</div>
                    </div>
                @endif
            </div>

            {{-- Bottom Academic Metadata Section --}}
            <div class="px-4 pb-4 mt-auto">
                <div class="row g-2">
                    <div class="col-6">
                        <div class="subject-meta-box d-flex align-items-center gap-2">
                            <i data-lucide="calendar" class="text-muted" style="width: 14px; height: 14px;"></i>
                            <div class="overflow-hidden">
                                <div class="text-muted" style="font-size: 0.65rem; line-height: 1;">ឆមាស</div>
                                <div class="fw-bold text-truncate" style="font-size: 0.78rem;">{{ $mark ? $mark->semester : 'កំពុងរង់ចាំ' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="subject-meta-box d-flex align-items-center gap-2">
                            <i data-lucide="clock" class="text-muted" style="width: 14px; height: 14px;"></i>
                            <div class="overflow-hidden">
                                <div class="text-muted" style="font-size: 0.65rem; line-height: 1;">ឆ្នាំសិក្សា</div>
                                <div class="fw-bold text-truncate" style="font-size: 0.78rem;">{{ $mark ? $mark->academic_year : 'កំពុងរង់ចាំ' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="badge bg-light p-4 rounded-circle mb-3" style="border: 2px dashed var(--bs-border-color);">
            <i data-lucide="inbox" style="width: 48px; height: 48px; opacity: 0.4;"></i>
        </div>
        <h5 class="fw-bold text-body">មិនទាន់បានចុះឈ្មោះមុខវិជ្ជា</h5>
        <p class="text-muted mb-0" style="font-size: 0.85rem;">អ្នកមិនទាន់បានចុះឈ្មោះក្នុងមុខវិជ្ជាសិក្សាណាមួយនៅឡើយទេ។</p>
    </div>
    @endforelse
</div>
@endsection
