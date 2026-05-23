@extends('layouts.app')

@section('title', 'Teacher Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ===== Welcome Banner ===== */
.welcome-banner {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%);
    border-radius: 20px;
    padding: 2rem 2.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    min-height: 140px;
    display: flex;
    align-items: center;
}
.welcome-banner::after {
    content: '';
    position: absolute;
    right: -20px;
    top: -20px;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.welcome-banner h2 { font-size: 1.75rem; font-weight: 700; margin-bottom: .25rem; }
.welcome-banner p { opacity: .85; margin-bottom: 0; font-size: .95rem; }

/* ===== Stats Cards ===== */
.stat-card-premium {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.03);
    transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
.stat-card-premium:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
}
.stat-card-premium .icon-container {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}
.stat-card-premium h3 {
    font-size: 1.75rem;
    font-weight: 800;
    margin-bottom: .25rem;
    color: var(--bs-body-color);
}
.stat-card-premium p {
    font-size: .85rem;
    font-weight: 600;
    color: #94a3b8;
    margin-bottom: 0;
}

/* Colors for icon containers */
.icon-purple { background: rgba(124, 58, 237, 0.1); color: #7c3aed; }
.icon-pink { background: rgba(219, 39, 119, 0.1); color: #db2777; }
.icon-blue { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
.icon-orange { background: rgba(234, 88, 12, 0.1); color: #ea580c; }

/* ===== Premium Cards ===== */
.premium-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.02);
}
.premium-card h5 {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 1.25rem;
    color: var(--bs-body-color);
    display: flex;
    align-items: center;
    gap: .5rem;
}

/* ===== List Items ===== */
.class-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-radius: 16px;
    background: var(--bs-secondary-bg, #f8fafc);
    border: 1px solid var(--bs-border-color, #f1f5f9);
    margin-bottom: .75rem;
    transition: all .2s;
}
.class-item:hover {
    background: var(--bs-border-color, #f1f5f9);
}
.class-info { display: flex; align-items: center; gap: 1rem; }
.class-avatar {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: .95rem;
}

/* ===== Quick Access Shortcuts ===== */
.shortcut-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: .75rem;
}
.shortcut-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    border-radius: 16px;
    background: var(--bs-secondary-bg, #f8fafc);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    color: var(--bs-body-color);
    text-decoration: none;
    font-weight: 600;
    font-size: .85rem;
    transition: all .2s;
    text-align: center;
}
.shortcut-btn:hover {
    background: #4f46e5;
    color: #fff !important;
    border-color: #4f46e5;
}
.shortcut-btn i {
    margin-bottom: .5rem;
    width: 24px;
    height: 24px;
}
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
    {{-- Welcome Banner --}}
    <div class="col-12">
        <div class="welcome-banner">
            <div>
                <p class="mb-1" style="font-size: .9rem; opacity: .8;">សូមស្វាគមន៍មកវិញ លោកគ្រូ/អ្នកគ្រូ</p>
                <h2>{{ $teacher->name }}</h2>
                <p style="font-size: .95rem; opacity: .9;">ឯកទេសបង្រៀន៖ <strong style="text-decoration: underline;">{{ $teacher->subject }}</strong></p>
            </div>
        </div>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-premium">
            <div class="icon-container icon-purple">
                <i data-lucide="users" class="lucide-md"></i>
            </div>
            <h3>{{ $totalStudents }}</h3>
            <p>សិស្សសរុប</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-premium">
            <div class="icon-container icon-pink">
                <i data-lucide="building-2" class="lucide-md"></i>
            </div>
            <h3>{{ $classes->count() }}</h3>
            <p>ថ្នាក់រៀនរបស់ខ្ញុំ</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-premium">
            <div class="icon-container icon-blue">
                <i data-lucide="book-open" class="lucide-md"></i>
            </div>
            <h3>{{ $subjectsCount }}</h3>
            <p>មុខវិជ្ជាសរុប</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-premium">
            <div class="icon-container icon-orange">
                <i data-lucide="clipboard-check" class="lucide-md"></i>
            </div>
            <h3>{{ $todayAttendanceCount }}</h3>
            <p>វត្តមានដែលបានពិនិត្យ</p>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Left: Classes List --}}
    <div class="col-lg-7">
        <div class="premium-card h-100">
            <h5><i data-lucide="building-2" style="color: #6366f1;"></i> ថ្នាក់រៀនដែលបានចាត់ចែង</h5>
            <p class="text-muted small mb-4">ទាំងនេះជាថ្នាក់រៀនដែលត្រូវបានចាត់ចែងជូនអ្នកជាគ្រូបន្ទុកថ្នាក់។</p>
            
            @forelse($classes as $class)
                <div class="class-item">
                    <div class="class-info">
                        <div class="class-avatar">
                            {{ strtoupper(substr($class->class_name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size: .95rem; color: var(--bs-body-color);">{{ $class->class_name }}</div>
                            <div class="text-muted small"><i data-lucide="map-pin" class="lucide-sm me-1"></i> Room: {{ $class->room_number ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge rounded-pill bg-label-indigo px-3 py-2" style="background: rgba(99,102,241,0.1); color: #6366f1; font-weight:600; font-size: .78rem;">
                            {{ $class->students->count() }} សិស្ស
                        </span>
                        <a href="{{ route('teacher.attendance', ['class_id' => $class->id]) }}" class="btn btn-sm btn-outline-primary" style="border-radius:10px;">
                            <i data-lucide="clipboard-check" class="lucide-sm"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i data-lucide="school" class="lucide-2xl mb-2" style="opacity: .3;"></i>
                    <p class="mb-0">មិនទាន់មានថ្នាក់រៀនត្រូវបានចាត់ចែងជូនអ្នកនៅឡើយទេ។</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Right: Quick Actions & Upcoming Exams --}}
    <div class="col-lg-5">
        <div class="row g-4">
            <div class="col-12">
                <div class="premium-card">
                    <h5><i data-lucide="zap" style="color: #db2777;"></i> សកម្មភាពរហ័ស</h5>
                    <div class="shortcut-grid mt-3">
                        <a href="{{ route('teacher.attendance') }}" class="shortcut-btn">
                            <i data-lucide="clipboard-check" style="color: #6366f1;"></i>
                            កត់ត្រាវត្តមាន
                        </a>
                        <a href="{{ route('teacher.scores') }}" class="shortcut-btn">
                            <i data-lucide="award" style="color: #db2777;"></i>
                            បញ្ចូលពិន្ទុ
                        </a>
                        <a href="{{ route('teacher.exams') }}" class="shortcut-btn">
                            <i data-lucide="calendar-clock" style="color: #2563eb;"></i>
                            កំណត់ម៉ោងប្រឡង
                        </a>
                        <a href="{{ route('teacher.exams') }}" class="shortcut-btn">
                            <i data-lucide="clock" style="color: #ea580c;"></i>
                            មើលការប្រឡង
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="premium-card">
                    <h5><i data-lucide="calendar-clock" style="color: #ea580c;"></i> ការប្រឡងនាពេលខាងមុខ</h5>
                    <p class="text-muted small mb-3">តេស្តដែលបានគ្រោងទុកសម្រាប់ថ្នាក់រៀនរបស់អ្នក។</p>
                    
                    @forelse($upcomingExams as $exam)
                        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                            <div>
                                <div class="fw-bold" style="font-size: .88rem; color: var(--bs-body-color);">{{ $exam->exam_name }} - {{ $exam->course->course_name }}</div>
                                <div class="text-muted small" style="font-size: .75rem;">
                                    <i data-lucide="calendar" class="lucide-sm me-1"></i> {{ $exam->exam_date->format('M d, Y') }} | 
                                    <i data-lucide="clock" class="lucide-sm me-1"></i> {{ substr($exam->start_time, 0, 5) }} - {{ substr($exam->end_time, 0, 5) }}
                                </div>
                            </div>
                            <span class="badge bg-secondary-subtle text-secondary" style="font-size: .75rem;">{{ $exam->schoolClass->class_name }}</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i data-lucide="calendar" class="lucide-lg mb-2" style="opacity: .3;"></i>
                            <p class="mb-0 small">មិនទាន់មានការប្រឡងគ្រោងទុកនាពេលខាងមុខឡើយ។</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
