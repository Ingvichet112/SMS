@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* -------------------------------------------------------
   Dashboard — Headstart-inspired UI
------------------------------------------------------- */
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
.stat-card-new:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,.1);
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

@media (max-width: 575.98px) {
    .stat-card-new {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem;
        gap: .5rem;
    }
    .stat-icon-new {
        width: 40px; height: 40px;
        font-size: 1.1rem;
    }
    .stat-value { font-size: 1.35rem; }
}

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

/* Teacher list rows */
.teacher-row {
    display: flex; align-items: center;
    padding: .65rem 1.4rem;
    gap: .75rem;
    border-bottom: 1px solid var(--bs-border-color, #f8f9fa);
    transition: background .15s;
}
.teacher-row:hover { background: var(--bs-secondary-bg, #f8f9fa); }
.teacher-row:last-child { border-bottom: none; }
.teacher-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: .85rem; color: #fff;
    flex-shrink: 0;
}

/* Legend dots */
.legend-dot {
    width: 10px; height: 10px; border-radius: 50%;
    display: inline-block;
}

/* Chart container */
.chart-wrap { position: relative; padding: 1rem 1.4rem 1.4rem; }

/* Select filter badge */
.filter-select {
    background: var(--bs-secondary-bg, #f8f9fa);
    border: 1px solid var(--bs-border-color, #dee2e6);
    border-radius: 8px;
    padding: .25rem .6rem;
    font-size: .8rem;
    color: var(--bs-body-color);
    cursor: pointer;
}
</style>
@endpush

@section('content')

{{-- -------------------------------------------------------
     Stat Cards Row
------------------------------------------------------- --}}
<div class="row g-3 mb-4">

    {{-- Students --}}
    <div class="col-6 col-xl-3">
        <div class="stat-card-new" style="background:linear-gradient(135deg,#e8f4fd,#d0eaf8);">
            <div class="stat-icon-new" style="background:rgba(99,162,235,.2);">
                <i data-lucide="users" style="stroke:#3b82f6;width:26px;height:26px;"></i>
            </div>
            <div>
                <div class="stat-label" style="color:#3b82f6;">សិស្សសរុប</div>
                <div class="stat-value" style="color:#1e3a5f;">{{ number_format($totalStudents) }}</div>
            </div>
        </div>
    </div>

    {{-- Teachers --}}
    <div class="col-6 col-xl-3">
        <div class="stat-card-new" style="background:linear-gradient(135deg,#f0ebff,#e4d9ff);">
            <div class="stat-icon-new" style="background:rgba(139,92,246,.2);">
                <i data-lucide="user-cog" style="stroke:#8b5cf6;width:26px;height:26px;"></i>
            </div>
            <div>
                <div class="stat-label" style="color:#8b5cf6;">គ្រូបង្រៀនសរុប</div>
                <div class="stat-value" style="color:#3b0764;">{{ number_format($totalTeachers) }}</div>
            </div>
        </div>
    </div>

    {{-- Courses --}}
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

    {{-- Classes --}}
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

{{-- -------------------------------------------------------
     Middle Row: Donut Chart + Teacher List
------------------------------------------------------- --}}
<div class="row g-3 mb-3">

    {{-- Students Donut Chart --}}
    <div class="col-lg-5">
        <div class="dash-card h-100">
            <div class="dash-card-header">
                <span class="dash-card-title">Students</span>
                <select class="filter-select" id="classFilter">
                    <option value="all">All Classes</option>
                    @foreach($classesList as $cls)
                        <option value="{{ $cls->id }}">{{ $cls->class_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="chart-wrap text-center">
                <div style="max-width:220px;margin:0 auto;position:relative;">
                    <canvas id="donutChart" height="220"></canvas>
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                        <div id="donutTotalText" style="font-size:1.75rem;font-weight:800;color:var(--bs-body-color);">{{ $totalStudents }}</div>
                        <div style="font-size:.72rem;color:#94a3b8;font-weight:600;text-transform:uppercase;">Total</div>
                    </div>
                </div>
                {{-- Legend --}}
                <div class="d-flex justify-content-center gap-4 mt-3">
                    <div class="d-flex align-items-center gap-2" style="font-size:.82rem;">
                        <span class="legend-dot" style="background:#93c5fd;"></span>
                        <span class="text-muted">Boys: <strong class="text-body" id="donutBoysText">{{ $maleStudents }}</strong></span>
                    </div>
                    <div class="d-flex align-items-center gap-2" style="font-size:.82rem;">
                        <span class="legend-dot" style="background:#c4b5fd;"></span>
                        <span class="text-muted">Girls: <strong class="text-body" id="donutGirlsText">{{ $femaleStudents }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Teacher List --}}
    <div class="col-lg-7">
        <div class="dash-card h-100">
            <div class="dash-card-header">
                <span class="dash-card-title">Teacher List</span>
                <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-outline-secondary rounded-3" style="font-size:.75rem;">
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            {{-- Table Header --}}
            <div style="padding:.5rem 1.4rem; display:grid; grid-template-columns:2fr 1fr 1.2fr 2fr auto; gap:.5rem; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:#94a3b8;">
                <span>Name</span><span>Class</span><span>Subject</span><span>Email</span><span></span>
            </div>

            {{-- Teacher Rows --}}
            @php
                $avatarColors = ['#6366f1','#8b5cf6','#10b981','#f59e0b','#ef4444','#3b82f6'];
            @endphp
            @forelse($recentTeachers as $i => $teacher)
            <div class="teacher-row" style="display:grid;grid-template-columns:2fr 1fr 1.2fr 2fr auto;gap:.5rem;align-items:center;">
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
                <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-light rounded-3 px-2">
                    <i class="bi bi-eye" style="font-size:.75rem;"></i>
                </a>
            </div>
            @empty
            <div class="text-center py-4 text-muted" style="font-size:.85rem;">
                <i class="bi bi-inbox d-block mb-1"></i>No teachers yet
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- -------------------------------------------------------
     Bottom Row: Earnings Bar + Enrollment Line Charts
------------------------------------------------------- --}}
<div class="row g-3">

    {{-- Earnings Bar Chart --}}
    <div class="col-lg-6">
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <div class="dash-card-title d-flex align-items-center gap-2">
                        <i data-lucide="banknote" style="stroke:#3b82f6;width:18px;height:18px;vertical-align:middle;"></i>
                        <span>Earnings Overview (ប្រាក់ចំណូលទទួលបាន)</span>
                    </div>
                    <div class="d-flex gap-3 mt-1">
                        <div class="d-flex align-items-center gap-1.5" style="font-size:.78rem;">
                            <span class="legend-dot" style="background:#bfe2f7;"></span>
                            <span class="text-muted">Collected: <strong class="text-body">${{ number_format($totalEarnings) }}</strong></span>
                        </div>
                        <div class="d-flex align-items-center gap-1.5" style="font-size:.78rem;">
                            <span class="legend-dot" style="background:#dcd0f7;"></span>
                            <span class="text-muted">Pending: <strong class="text-body">${{ number_format($totalPending) }}</strong></span>
                        </div>
                    </div>
                </div>
                <select class="filter-select" id="earningsPeriodSelect">
                    <option value="this_week">This week</option>
                    <option value="last_week">Last week</option>
                </select>
            </div>
            <div class="chart-wrap" style="height:220px;">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Earnings / Enrollment Line Chart --}}
    <div class="col-lg-6">
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <div class="dash-card-title">Enrollment Trend</div>
                    <div class="d-flex gap-3 mt-1">
                        <div class="d-flex align-items-center gap-1" style="font-size:.75rem;">
                            <span class="legend-dot" style="background:#93c5fd;"></span>
                            <span class="text-muted">New Students</span>
                        </div>
                        <div class="d-flex align-items-center gap-1" style="font-size:.75rem;">
                            <span class="legend-dot" style="background:#c4b5fd;"></span>
                            <span class="text-muted">New Teachers</span>
                        </div>
                    </div>
                </div>
                <select class="filter-select">
                    <option>This Month</option>
                </select>
            </div>
            <div class="chart-wrap" style="height:220px;">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
// -------------------------------------------------------
// Detect dark mode for chart colors
// -------------------------------------------------------
const isDark = () => document.getElementById('htmlRoot').getAttribute('data-bs-theme') === 'dark';
const gridColor = () => isDark() ? 'rgba(255,255,255,.06)' : 'rgba(0,0,0,.06)';
const labelColor = () => isDark() ? '#94a3b8' : '#94a3b8';

// -------------------------------------------------------
// Donut Chart — ការបែងចែកភេទសិស្ស
// -------------------------------------------------------
const classStats = @json($classStats);
const donutCtx = document.getElementById('donutChart').getContext('2d');
const donutChart = new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Boys', 'Girls'],
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
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.raw} students`
                }
            }
        },
        animation: { animateRotate: true, duration: 1000 }
    }
});

// Interactive filter dropdown for class-level student statistics
document.getElementById('classFilter').addEventListener('change', function() {
    const stats = classStats[this.value];
    if (stats) {
        // Update center total count text
        document.getElementById('donutTotalText').innerText = stats.total;
        // Update legend values
        document.getElementById('donutBoysText').innerText = stats.male;
        document.getElementById('donutGirlsText').innerText = stats.female;
        // Update chart segments
        donutChart.data.datasets[0].data = [stats.male, stats.female];
        donutChart.update();
    }
});

// -------------------------------------------------------
// Earnings Line/Area Chart (ប្រាក់ចំណូលទទួលបាន) — Ultra Modern
// -------------------------------------------------------
// -------------------------------------------------------
// Earnings Bar Chart (Collected vs Pending) — Custom Double-Bar Style
// -------------------------------------------------------
const earningsCtx = document.getElementById('earningsChart').getContext('2d');

const thisWeekCollected = @json($thisWeekCollected);
const thisWeekPending = @json($thisWeekPending);
const lastWeekCollected = @json($lastWeekCollected);
const lastWeekPending = @json($lastWeekPending);

const earningsChart = new Chart(earningsCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        datasets: [
            {
                label: 'Collected',
                data: thisWeekCollected,
                backgroundColor: '#bfe2f7', // Soft Sky Blue
                borderRadius: 6,
                borderSkipped: 'bottom',
                barThickness: 12,
                maxBarThickness: 12,
            },
            {
                label: 'Pending',
                data: thisWeekPending,
                backgroundColor: '#dcd0f7', // Soft Purple
                borderRadius: 6,
                borderSkipped: 'bottom',
                barThickness: 12,
                maxBarThickness: 12,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        barPercentage: 0.6,
        categoryPercentage: 0.6,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#111111',
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                titleFont: { size: 11, weight: 'bold' },
                bodyFont: { size: 11 },
                padding: { top: 6, right: 10, bottom: 6, left: 10 },
                cornerRadius: 4,
                displayColors: false,
                caretSize: 4,
                caretPadding: 4,
                callbacks: {
                    label: ctx => ` ${ctx.dataset.label}: $${ctx.raw.toLocaleString()} USD`
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: { color: labelColor(), font: { size: 11 } }
            },
            y: {
                grid: {
                    color: gridColor(),
                    borderDash: [4, 4],
                    drawTicks: false
                },
                border: { display: false },
                ticks: {
                    color: labelColor(),
                    font: { size: 11 },
                    callback: value => '$' + value.toLocaleString()
                },
                beginAtZero: true,
            }
        }
    }
});

// interactive filter dropdown for weekly earnings
document.getElementById('earningsPeriodSelect').addEventListener('change', function() {
    const val = this.value;
    if (val === 'this_week') {
        earningsChart.data.datasets[0].data = thisWeekCollected;
        earningsChart.data.datasets[1].data = thisWeekPending;
    } else {
        earningsChart.data.datasets[0].data = lastWeekCollected;
        earningsChart.data.datasets[1].data = lastWeekPending;
    }
    earningsChart.update();
});

// -------------------------------------------------------
// Enrollment Trend Area Chart — Ultra Modern
// -------------------------------------------------------
const enrollCtx = document.getElementById('enrollmentChart').getContext('2d');

const gradStudents = enrollCtx.createLinearGradient(0, 0, 0, 200);
gradStudents.addColorStop(0, 'rgba(59,130,246,0.25)');
gradStudents.addColorStop(1, 'rgba(59,130,246,0.01)');

const gradTeachers = enrollCtx.createLinearGradient(0, 0, 0, 200);
gradTeachers.addColorStop(0, 'rgba(139,92,246,0.2)');
gradTeachers.addColorStop(1, 'rgba(139,92,246,0.01)');

new Chart(enrollCtx, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
            {
                label: 'New Students',
                data: [12, 19, 15, 28, 25, 32, 20, 18, 30, 22, 15, 27],
                borderColor: '#3b82f6',
                borderWidth: 3,
                backgroundColor: gradStudents,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#3b82f6',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2,
            },
            {
                label: 'New Teachers',
                data: [3, 5, 2, 8, 4, 6, 3, 5, 7, 4, 2, 5],
                borderColor: '#8b5cf6',
                borderWidth: 3,
                backgroundColor: gradTeachers,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#8b5cf6',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                mode: 'index',
                intersect: false,
                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                titleFont: { size: 12, weight: 'bold' },
                bodyFont: { size: 12 },
                padding: 10,
                cornerRadius: 8
            }
        },
        scales: {
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: { color: labelColor(), font: { size: 11 } }
            },
            y: {
                grid: {
                    color: gridColor(),
                    borderDash: [5, 5],
                    drawTicks: false
                },
                border: { display: false },
                ticks: { color: labelColor(), font: { size: 11 } },
                beginAtZero: true,
            }
        }
    }
});
</script>
@endpush
