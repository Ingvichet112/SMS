@extends('layouts.app')

@section('title', 'Guest Dashboard')
@section('page-title', 'Guest Access')

@push('styles')
<style>
.guest-banner {
    background: linear-gradient(135deg, #6366f1, #a855f7);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.5);
}
.guest-banner::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}
.stat-card-new {
    border-radius: 16px;
    border: none;
    padding: 1.1rem 1.4rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}
.stat-icon-new {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.stat-label { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; opacity: .7; }
.stat-value { font-size: 1.65rem; font-weight: 800; line-height: 1.1; }

.dash-card {
    border-radius: 20px;
    border: 1px solid var(--bs-border-color, #e9ecef);
    background: var(--bs-card-bg, #fff);
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    overflow: hidden;
}
.dash-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.1rem 1.4rem .6rem;
    border-bottom: 1px solid var(--bs-border-color, #f1f3f5);
}
.dash-card-title { font-weight: 700; font-size: .95rem; }

.teacher-row {
    display: flex; align-items: center;
    padding: .65rem 1.4rem;
    gap: .75rem;
    border-bottom: 1px solid var(--bs-border-color, #f8f9fa);
}
.teacher-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: .85rem; color: #fff;
    flex-shrink: 0;
}
.legend-dot {
    width: 10px; height: 10px; border-radius: 50%;
    display: inline-block;
}
.chart-wrap { position: relative; padding: 1rem 1.4rem 1.4rem; }
</style>
@endpush

@section('content')

<div class="guest-banner">
    <div class="d-flex align-items-center gap-3 mb-2">
        <i data-lucide="info" style="width:24px;height:24px;"></i>
        <h4 class="mb-0 fw-bold">របៀបសម្រាប់អ្នកទស្សនា (Guest Mode)</h4>
    </div>
    <p class="mb-3 opacity-75">អ្នកកំពុងប្រើប្រាស់ប្រព័ន្ធក្នុងនាមជាភ្ញៀវ។ អ្នកអាចមើលស្ថិតិទូទៅបាន ប៉ុន្តែមិនអាចកែប្រែទិន្នន័យបានទេ។</p>
    <a href="{{ route('login') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">
        ចូលប្រើប្រាស់ពេញលេញ
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card-new" style="background:linear-gradient(135deg,#e8f4fd,#d0eaf8);">
            <div class="stat-icon-new" style="background:rgba(99,162,235,.2);">
                <i data-lucide="users" style="stroke:#3b82f6;width:26px;height:26px;"></i>
            </div>
            <div>
                <div class="stat-label" style="color:#3b82f6;">ចំនួនសិស្ស</div>
                <div class="stat-value" style="color:#1e3a5f;">{{ number_format($totalStudents) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card-new" style="background:linear-gradient(135deg,#f0ebff,#e4d9ff);">
            <div class="stat-icon-new" style="background:rgba(139,92,246,.2);">
                <i data-lucide="user-cog" style="stroke:#8b5cf6;width:26px;height:26px;"></i>
            </div>
            <div>
                <div class="stat-label" style="color:#8b5cf6;">ចំនួនគ្រូ</div>
                <div class="stat-value" style="color:#3b0764;">{{ number_format($totalTeachers) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card-new" style="background:linear-gradient(135deg,#fce7ff,#f5d0fe);">
            <div class="stat-icon-new" style="background:rgba(217,70,239,.2);">
                <i data-lucide="book-open" style="stroke:#d946ef;width:26px;height:26px;"></i>
            </div>
            <div>
                <div class="stat-label" style="color:#d946ef;">មុខវិជ្ជាសរុប</div>
                <div class="stat-value" style="color:#4a044e;">{{ number_format($totalCourses) }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card-new" style="background:linear-gradient(135deg,#dcfce7,#bbf7d0);">
            <div class="stat-icon-new" style="background:rgba(16,185,129,.2);">
                <i data-lucide="building-2" style="stroke:#10b981;width:26px;height:26px;"></i>
            </div>
            <div>
                <div class="stat-label" style="color:#10b981;">ថ្នាក់រៀនសរុប</div>
                <div class="stat-value" style="color:#064e3b;">{{ number_format($totalClasses) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="dash-card h-100">
            <div class="dash-card-header">
                <span class="dash-card-title">ការបែងចែកសិស្ស</span>
            </div>
            <div class="chart-wrap text-center">
                <div style="max-width:220px;margin:0 auto;position:relative;">
                    <canvas id="donutChart" height="220"></canvas>
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                        <div style="font-size:1.75rem;font-weight:800;color:var(--bs-body-color);">{{ $totalStudents }}</div>
                        <div style="font-size:.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;">សរុប</div>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-4 mt-3">
                    <div class="d-flex align-items-center gap-2" style="font-size:.82rem;">
                        <span class="legend-dot" style="background:#93c5fd;"></span>
                        <span class="text-muted">ប្រុស: <strong class="text-body">{{ $maleStudents }}</strong></span>
                    </div>
                    <div class="d-flex align-items-center gap-2" style="font-size:.82rem;">
                        <span class="legend-dot" style="background:#c4b5fd;"></span>
                        <span class="text-muted">ស្រី: <strong class="text-body">{{ $femaleStudents }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="dash-card h-100">
            <div class="dash-card-header">
                <span class="dash-card-title">បញ្ជីគ្រូបង្រៀន</span>
            </div>
            <div style="padding:.5rem 1.4rem; display:grid; grid-template-columns:2fr 1fr 1.2fr 2fr; gap:.5rem; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:#94a3b8;">
                <span>ឈ្មោះ</span><span>ថ្នាក់</span><span>មុខវិជ្ជា</span><span>អ៊ីមែល</span>
            </div>
            @php
                $avatarColors = ['#6366f1','#8b5cf6','#10b981','#f59e0b','#ef4444','#3b82f6'];
            @endphp
            @forelse($recentTeachers as $i => $teacher)
            <div class="teacher-row" style="display:grid;grid-template-columns:2fr 1fr 1.2fr 2fr;gap:.5rem;align-items:center;">
                <div class="d-flex align-items-center gap-2">
                    <div class="teacher-avatar" style="background:{{ $avatarColors[$i % count($avatarColors)] }};">
                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                    </div>
                    <span style="font-size:.85rem;font-weight:500;">{{ $teacher->name }}</span>
                </div>
                <span style="font-size:.82rem;color:#64748b;">
                    {{ $teacher->classes->first()?->class_name ?? '—' }}
                </span>
                <span style="font-size:.82rem;">
                    <span class="badge rounded-pill px-2" style="background:rgba(99,102,241,.1);color:#6366f1;font-size:.72rem;">
                        {{ Str::limit($teacher->subject, 10) }}
                    </span>
                </span>
                <span style="font-size:.78rem;color:#94a3b8;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    {{ $teacher->email }}
                </span>
            </div>
            @empty
            <div class="text-center py-4 text-muted" style="font-size:.85rem;">
                <i class="bi bi-inbox d-block mb-1"></i>មិនទាន់មានទិន្នន័យ
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
const donutCtx = document.getElementById('donutChart').getContext('2d');
new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: ['ប្រុស', 'ស្រី'],
        datasets: [{
            data: [{{ $maleStudents }}, {{ $femaleStudents }}],
            backgroundColor: ['#93c5fd', '#c4b5fd'],
            borderColor: ['#bfdbfe', '#ddd6fe'],
            borderWidth: 3,
            hoverOffset: 6,
        }]
    },
    options: {
        cutout: '72%',
        plugins: {
            legend: { display: false },
        },
        animation: { animateRotate: true, duration: 1000 }
    }
});
</script>
@endpush
