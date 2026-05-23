@extends('layouts.app')

@section('title', 'Student Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ===== Welcome Banner ===== */
.welcome-banner {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
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
.welcome-banner::before {
    content: '';
    position: absolute;
    right: 60px;
    bottom: -40px;
    width: 120px;
    height: 120px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
}
.welcome-banner h2 { font-size: 1.75rem; font-weight: 700; margin-bottom: .25rem; }
.welcome-banner p { opacity: .85; margin-bottom: .75rem; font-size: .95rem; }
.welcome-banner .banner-link {
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    transition: gap .2s;
}
.welcome-banner .banner-link:hover { gap: .75rem; }
.welcome-illustration {
    position: absolute;
    right: 2rem;
    bottom: 0;
    height: 120px;
    opacity: .9;
}

/* ===== Score Cards ===== */
.score-section {
    background: var(--bs-card-bg, #fff);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    border: 1px solid var(--bs-border-color, #f1f5f9);
}
.score-section h6 { font-weight: 700; font-size: .95rem; color: var(--bs-body-color); }

/* Circular Progress */
.circle-progress-wrap {
    position: relative;
    width: 130px;
    height: 130px;
    margin: 0 auto;
}
.circle-progress-wrap svg { transform: rotate(-90deg); }
.circle-progress-wrap .circle-bg {
    fill: none;
    stroke: var(--bs-border-color, #e2e8f0);
    stroke-width: 8;
}
.circle-progress-wrap .circle-fill {
    fill: none;
    stroke-width: 8;
    stroke-linecap: round;
    transition: stroke-dashoffset 1.5s ease;
}
.circle-progress-wrap .circle-text {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.circle-progress-wrap .circle-text .pct {
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1;
    color: var(--bs-body-color);
}
.circle-progress-wrap .circle-text .label {
    font-size: .7rem;
    color: #94a3b8;
    margin-top: 4px;
    font-weight: 600;
}

/* Legends */
.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

/* ===== Course Progress Bars ===== */
.course-progress-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: .85rem;
}
.course-progress-item:last-child { margin-bottom: 0; }
.course-progress-item .course-name {
    width: 80px;
    font-size: .8rem;
    font-weight: 600;
    color: var(--bs-body-color);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.course-progress-item .progress {
    flex: 1;
    height: 10px;
    border-radius: 10px;
    background: var(--bs-secondary-bg, #f1f5f9);
}
.course-progress-item .progress-bar { border-radius: 10px; transition: width 1.5s ease; }
.course-progress-item .score-label {
    font-size: .78rem;
    font-weight: 700;
    color: #64748b;
    min-width: 35px;
    text-align: right;
}

/* ===== Calendar Widget ===== */
.calendar-widget {
    background: var(--bs-card-bg, #fff);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    border: 1px solid var(--bs-border-color, #f1f5f9);
}
.calendar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}
.calendar-header h6 { font-weight: 700; font-size: 1rem; margin: 0; }
.calendar-header .cal-nav {
    display: flex;
    gap: .25rem;
}
.calendar-header .cal-nav button {
    background: none;
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 8px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--bs-body-color);
    transition: all .2s;
}
.calendar-header .cal-nav button:hover { background: var(--bs-secondary-bg, #f8fafc); }
.cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    text-align: center;
}
.cal-grid .cal-day-name {
    font-size: .7rem;
    font-weight: 700;
    color: #94a3b8;
    padding: .5rem 0;
    text-transform: uppercase;
}
.cal-grid .cal-day {
    font-size: .82rem;
    padding: .45rem;
    border-radius: 10px;
    cursor: default;
    font-weight: 500;
    color: var(--bs-body-color);
    transition: all .2s;
}
.cal-grid .cal-day.today {
    background: #f97316;
    color: #fff;
    font-weight: 700;
    border-radius: 50%;
}
.cal-grid .cal-day.other-month { color: #cbd5e1; }

/* ===== Info Card (Class Details) ===== */
.info-card-widget {
    background: var(--bs-card-bg, #fff);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    border: 1px solid var(--bs-border-color, #f1f5f9);
    margin-top: 1rem;
}
.info-card-widget .info-tag {
    display: inline-block;
    background: #fff7ed;
    color: #f97316;
    font-size: .7rem;
    font-weight: 700;
    padding: .25rem .75rem;
    border-radius: 6px;
    margin-bottom: .5rem;
    text-transform: uppercase;
}
.info-card-widget h5 { font-weight: 700; font-size: 1.05rem; margin-bottom: .5rem; }
.info-card-widget .info-desc { font-size: .82rem; color: #64748b; line-height: 1.5; margin-bottom: 1rem; }
.avatar-stack {
    display: flex;
    align-items: center;
}
.avatar-stack img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid var(--bs-card-bg, #fff);
    margin-left: -8px;
    object-fit: cover;
}
.avatar-stack img:first-child { margin-left: 0; }
.avatar-stack .more-badge {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #fef3c7;
    color: #f59e0b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .6rem;
    font-weight: 700;
    margin-left: -8px;
    border: 2px solid var(--bs-card-bg, #fff);
}
.info-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: .78rem;
    color: #64748b;
    margin: .75rem 0 1rem;
}
.info-meta i { margin-right: .25rem; }
.btn-outline-orange {
    border: 2px solid #f97316;
    color: #f97316;
    background: transparent;
    border-radius: 12px;
    padding: .5rem 1.25rem;
    font-weight: 600;
    font-size: .85rem;
    transition: all .2s;
}
.btn-outline-orange:hover { background: #f97316; color: #fff; }
.btn-fill-dark {
    background: #1e293b;
    color: #fff;
    border: 2px solid #1e293b;
    border-radius: 12px;
    padding: .5rem 1.25rem;
    font-weight: 600;
    font-size: .85rem;
    transition: all .2s;
}
.btn-fill-dark:hover { background: #334155; border-color: #334155; color: #fff; }

/* ===== Media Lessons ===== */
.media-section {
    background: var(--bs-card-bg, #fff);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    border: 1px solid var(--bs-border-color, #f1f5f9);
}
.media-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--bs-border-color, #f1f5f9);
}
.media-item:last-child { border-bottom: none; }
.media-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.media-icon.purple { background: #ede9fe; color: #8b5cf6; }
.media-icon.blue { background: #dbeafe; color: #3b82f6; }
.media-icon.orange { background: #fff7ed; color: #f97316; }
.media-info { flex: 1; }
.media-info .media-title { font-weight: 600; font-size: .9rem; color: var(--bs-body-color); }
.media-info .media-meta { font-size: .75rem; color: #94a3b8; display: flex; gap: 1rem; margin-top: .25rem; }
.media-more {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #94a3b8;
    transition: all .2s;
}
.media-more:hover { background: var(--bs-secondary-bg, #f8fafc); }

/* ===== Profile Quick Card ===== */
.profile-quick {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-bottom: 1.25rem;
}
.profile-quick img {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    object-fit: cover;
}
.profile-quick .pq-name { font-weight: 700; font-size: .9rem; color: var(--bs-body-color); }
.profile-quick .pq-email { font-size: .75rem; color: #94a3b8; }

/* ===== Responsive ===== */
@media (max-width: 991.98px) {
    .welcome-illustration { display: none; }
    .dashboard-right { margin-top: 1.5rem; }
}
@media (max-width: 767.98px) {
    .score-section { padding: 1.25rem; }
    .circle-progress-wrap { width: 100px; height: 100px; }
    .circle-progress-wrap .circle-text .pct { font-size: 1.25rem; }
}
</style>
@endpush

@section('content')
<div class="row g-4">
    {{-- ========== LEFT COLUMN (Main Content) ========== --}}
    <div class="col-lg-8">
        {{-- Welcome Banner --}}
        <div class="welcome-banner mb-4" id="welcomeBanner">
            <div style="position:relative;z-index:2;">
                <p class="mb-1" style="font-size:.9rem;opacity:.8;">សូមស្វាគមន៍ត្រឡប់មកវិញ</p>
                <h2>{{ $student->first_name }}</h2>
                <a href="{{ route('student.subjects') }}" class="banner-link">
                    ទៅកាន់មុខវិជ្ជាសិក្សារបស់អ្នក <i data-lucide="arrow-right" style="width:16px;height:16px;"></i>
                </a>
            </div>
            {{-- SVG Illustration --}}
            <svg class="welcome-illustration" viewBox="0 0 200 140" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="90" r="45" fill="rgba(255,255,255,0.15)"/>
                <circle cx="70" cy="70" r="20" fill="#fbbf24"/>
                <circle cx="70" cy="55" r="12" fill="#fde68a"/>
                <rect x="58" y="70" width="24" height="30" rx="8" fill="#fbbf24"/>
                <circle cx="130" cy="70" r="20" fill="#fb923c"/>
                <circle cx="130" cy="55" r="12" fill="#fdba74"/>
                <rect x="118" y="70" width="24" height="30" rx="8" fill="#fb923c"/>
                <circle cx="100" cy="60" r="22" fill="#fff" opacity=".3"/>
                <circle cx="100" cy="45" r="14" fill="#fff" opacity=".4"/>
                <rect x="86" y="60" width="28" height="35" rx="9" fill="#fff" opacity=".3"/>
                <rect x="40" y="110" width="120" height="12" rx="6" fill="rgba(255,255,255,0.1)"/>
                <rect x="55" y="100" width="15" height="15" rx="3" fill="#fbbf24" opacity=".6"/>
                <rect x="80" y="95" width="12" height="18" rx="3" fill="#818cf8" opacity=".5"/>
                <rect x="105" y="98" width="14" height="16" rx="3" fill="#fb923c" opacity=".5"/>
                <rect x="130" y="102" width="12" height="12" rx="3" fill="#a78bfa" opacity=".5"/>
            </svg>
        </div>

        {{-- Score & Courses Row --}}
        <div class="row g-4 mb-4">
            {{-- Today's Goal & Overall Score --}}
            <div class="col-md-6">
                <div class="score-section h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-0">លទ្ធផលសិក្សា</h6>
                            <small class="text-muted">វត្តមាន និងនិទ្ទេសជាក់ស្តែង</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-around">
                        {{-- Attendance Rate Circle --}}
                        <div class="circle-progress-wrap" data-percent="{{ $attendanceRate }}">
                            <svg width="130" height="130" viewBox="0 0 130 130">
                                <circle class="circle-bg" cx="65" cy="65" r="55"/>
                                <circle class="circle-fill" cx="65" cy="65" r="55"
                                    stroke="#22c55e"
                                    stroke-dasharray="345.58"
                                    stroke-dashoffset="345.58"/>
                            </svg>
                            <div class="circle-text">
                                <span class="pct">{{ $attendanceRate }}%</span>
                                <span class="label">វត្តមាន</span>
                            </div>
                        </div>
                        {{-- Overall Score Circle --}}
                        <div class="circle-progress-wrap" data-percent="{{ $overallScore }}">
                            <svg width="130" height="130" viewBox="0 0 130 130">
                                <circle class="circle-bg" cx="65" cy="65" r="55"/>
                                <circle class="circle-fill" cx="65" cy="65" r="55"
                                    stroke="#6366f1"
                                    stroke-dasharray="345.58"
                                    stroke-dashoffset="345.58"/>
                            </svg>
                            <div class="circle-text">
                                <span class="pct">{{ $overallScore }}%</span>
                                <span class="label">ពិន្ទុរួម</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-3" style="font-size:.72rem;">
                        <span><span class="legend-dot" style="background:#22c55e;"></span> វត្តមាន</span>
                        <span><span class="legend-dot" style="background:#6366f1;"></span> ពិន្ទុរួម</span>
                    </div>
                </div>
            </div>

            {{-- Your Courses --}}
            <div class="col-md-6">
                <div class="score-section h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">មុខវិជ្ជាសិក្សារបស់អ្នក</h6>
                        <a href="{{ route('student.subjects') }}" class="text-decoration-none" style="font-size:.8rem;color:#6366f1;font-weight:600;">មើលទាំងអស់</a>
                    </div>
                    @php $colors = ['#6366f1','#3b82f6','#f97316','#10b981','#8b5cf6','#ef4444']; @endphp
                    @forelse($courses->take(5) as $i => $course)
                        @php
                            $mark = $course->marks->first();
                            $score = $mark ? $mark->score : 0;
                        @endphp
                        <div class="course-progress-item">
                            <span class="course-name" title="{{ $course->course_name }}">{{ $course->course_name }}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width:{{ $score }}%;background:{{ $colors[$i % count($colors)] }};"></div>
                            </div>
                            <span class="score-label">{{ $score }}%</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i data-lucide="book-open" class="lucide-xl mb-2" style="opacity:.3;"></i>
                            <p class="mb-0" style="font-size:.85rem;">មិនទាន់មានមុខវិជ្ជាសិក្សានៅឡើយទេ</p>
                        </div>
                    @endforelse
                    <div class="d-flex justify-content-center gap-3 mt-3" style="font-size:.72rem;">
                        <span><span class="legend-dot" style="background:#6366f1;"></span> គោលដៅរបស់អ្នក</span>
                        <span><span class="legend-dot" style="background:#1e293b;"></span> វឌ្ឍនភាព</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Attendance History --}}
        <div class="media-section mb-4 animate-fade-in">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0" style="color: var(--bs-body-color);"><i data-lucide="clipboard-check" class="me-2 text-success" style="vertical-align: -2px;"></i> ប្រវត្តិនៃការកត់ត្រាវត្តមានថ្មីៗ</h6>
                <span class="badge bg-success-subtle text-success px-2.5 py-1 rounded-pill small fw-bold" style="font-size: 0.72rem;">ស្ថិតិជាក់ស្តែង</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--bs-border-color, #e2e8f0); font-size: 0.72rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">
                            <th>កាលបរិច្ឆេទ</th>
                            <th>មុខវិជ្ជា</th>
                            <th class="text-center">ស្ថានភាព</th>
                            <th>កំណត់សម្គាល់</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceLogs as $log)
                            <tr>
                                <td style="font-size: 0.85rem; font-weight: 600; color: var(--bs-body-color);">
                                    {{ \Carbon\Carbon::parse($log->attendance_date)->format('l, M d, Y') }}
                                </td>
                                <td style="font-size: 0.85rem; font-weight: 700; color: var(--bs-body-color);">
                                    {{ $log->course->course_name }}
                                </td>
                                <td class="text-center">
                                    @if($log->status === 'present')
                                        <span class="badge bg-success-subtle text-success px-2.5 py-1.5" style="border-radius: 8px; font-weight: 700; font-size: 0.72rem; border: 1px solid rgba(16, 185, 129, 0.2);">
                                            <i data-lucide="check" class="lucide-sm me-1" style="vertical-align: -1px;"></i> វត្តមាន
                                        </span>
                                    @elseif($log->status === 'late')
                                        <span class="badge bg-warning-subtle text-warning px-2.5 py-1.5" style="border-radius: 8px; font-weight: 700; font-size: 0.72rem; border: 1px solid rgba(245, 158, 11, 0.2); color: #d97706 !important;">
                                            <i data-lucide="clock" class="lucide-sm me-1" style="vertical-align: -1px;"></i> យឺត
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-2.5 py-1.5" style="border-radius: 8px; font-weight: 700; font-size: 0.72rem; border: 1px solid rgba(239, 68, 68, 0.2);">
                                            <i data-lucide="x" class="lucide-sm me-1" style="vertical-align: -1px;"></i> អវត្តមាន
                                        </span>
                                    @endif
                                </td>
                                <td style="font-size: 0.82rem; color: #64748b; font-style: italic;">
                                    {{ $log->remarks ?: 'គ្មានកំណត់សម្គាល់' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i data-lucide="clipboard-list" class="lucide-xl mb-2" style="opacity: 0.3;"></i>
                                    <p class="mb-0 small">មិនទាន់មានការកត់ត្រាវត្តមានដោយគ្រូរបស់អ្នកនៅឡើយទេ។</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Media for Lessons --}}
        <div class="media-section">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">ឯកសារមេរៀន</h6>
                <a href="{{ route('student.subjects') }}" class="text-decoration-none" style="font-size:.85rem;color:#6366f1;font-weight:600;">មើលទាំងអស់</a>
            </div>
            @php $iconStyles = ['purple','blue','orange']; @endphp
            @forelse($courses->take(3) as $i => $course)
                <div class="media-item">
                    <div class="media-icon {{ $iconStyles[$i % 3] }}">
                        <i data-lucide="file-text" style="width:20px;height:20px;"></i>
                    </div>
                    <div class="media-info">
                        <div class="media-title">{{ $course->course_name }}</div>
                        <div class="media-meta">
                            <span><i data-lucide="users" class="lucide-sm"></i> {{ $classmatesCount }} សមាជិក</span>
                            <span><i data-lucide="hard-drive" class="lucide-sm"></i> {{ $course->credit }} ក្រេឌីត</span>
                        </div>
                    </div>
                    <button class="media-more"><i data-lucide="more-horizontal" style="width:16px;height:16px;"></i></button>
                </div>
            @empty
                <div class="text-center text-muted py-3">
                    <p class="mb-0" style="font-size:.85rem;">មិនទាន់មានមេរៀននៅឡើយទេ</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ========== RIGHT COLUMN (Sidebar Widgets) ========== --}}
    <div class="col-lg-4 dashboard-right">
        {{-- Profile Quick Card --}}
        <div class="profile-quick">
            <img src="{{ $student->photo_url }}" alt="Avatar">
            <div>
                <div class="pq-name">{{ $student->full_name }}</div>
                <div class="pq-email">{{ $student->email ?? 'គ្មានអ៊ីមែល' }}</div>
            </div>
        </div>

        {{-- Calendar Widget --}}
        <div class="calendar-widget" id="calendarWidget">
            <div class="calendar-header">
                <h6 id="calMonthYear"></h6>
                <div class="cal-nav">
                    <button onclick="changeMonth(-1)" title="Previous"><i data-lucide="chevron-left" style="width:14px;height:14px;"></i></button>
                    <button onclick="changeMonth(1)" title="Next"><i data-lucide="chevron-right" style="width:14px;height:14px;"></i></button>
                </div>
            </div>
            <div class="cal-grid" id="calGrid"></div>
        </div>

        {{-- Upcoming Exams Widget --}}
        <div class="info-card-widget" id="exams-section" style="margin-top: 1rem; border-left: 4px solid #ea580c;">
            <span class="info-tag" style="background: rgba(234,88,12,0.1); color: #ea580c;">កាលវិភាគប្រឡង</span>
            <h5>ការប្រឡងនាពេលខាងមុខ</h5>
            <p class="info-desc">ផ្ទៀងផ្ទាត់ពេលវេលាប្រឡងពាក់កណ្តាលឆមាស ឆមាស និងការតេស្តនានារបស់អ្នក។</p>
            
            <div class="pt-2">
                @forelse($upcomingExams as $exam)
                    <div class="d-flex align-items-center justify-content-between p-2 border-bottom mb-2">
                        <div>
                            <div class="fw-bold" style="font-size: .82rem; color: var(--bs-body-color);">{{ $exam->exam_name }} - {{ $exam->course->course_name }}</div>
                            <div class="text-muted small" style="font-size: .7rem;">
                                <i data-lucide="calendar" class="lucide-sm me-1"></i> {{ $exam->exam_date->format('M d, Y') }} | 
                                <i data-lucide="clock" class="lucide-sm me-1"></i> {{ substr($exam->start_time, 0, 5) }} - {{ substr($exam->end_time, 0, 5) }}
                            </div>
                        </div>
                        <span class="badge bg-light text-dark border small" style="font-size: .68rem; padding: 4px 8px;">{{ $exam->room ?? 'N/A' }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-3">
                        <i data-lucide="calendar-x" class="lucide-md mb-1" style="opacity: .3;"></i>
                        <p class="mb-0 small" style="font-size: .75rem;">មិនទាន់មានកាលវិភាគប្រឡងនាពេលខាងមុខឡើយ។</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Class Info Card --}}
        <div class="info-card-widget">
            <span class="info-tag">ថ្នាក់រៀនរបស់អ្នក</span>
            <h5>{{ $student->schoolClass->class_name ?? 'មិនទាន់មានការចាត់ចែងថ្នាក់' }}</h5>
            <p class="info-desc">
                @if($student->schoolClass)
                    បន្ទប់ {{ $student->schoolClass->room_number ?? 'N/A' }} •
                    គ្រូ៖ {{ $student->schoolClass->teacher->name ?? 'មិនទាន់ចាត់ចែង' }}
                @else
                    អ្នកមិនទាន់ត្រូវបានចាត់ចូលថ្នាក់ណាមួយនៅឡើយទេ។
                @endif
            </p>

            @if($student->schoolClass && $student->schoolClass->students->count() > 0)
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="avatar-stack">
                        @foreach($student->schoolClass->students->take(3) as $mate)
                            <img src="{{ $mate->photo_url }}" alt="{{ $mate->full_name }}" title="{{ $mate->full_name }}">
                        @endforeach
                        @if($classmatesCount > 3)
                            <span class="more-badge">+{{ $classmatesCount - 3 }}</span>
                        @endif
                    </div>
                    <span style="font-size:.78rem;color:#f59e0b;font-weight:600;">{{ $classmatesCount }} មិត្តរួមថ្នាក់</span>
                </div>
            @endif

            <div class="info-meta">
                <span><i data-lucide="clock" class="lucide-sm"></i> {{ $courses->count() }} មុខវិជ្ជា</span>
                <span><i data-lucide="users" class="lucide-sm"></i> {{ $classmatesCount }} សិស្ស</span>
            </div>

            @if($student->schoolClass && $student->schoolClass->teacher)
                <div class="pt-3 border-top mt-2 mb-3">
                    <div class="small text-muted mb-2 text-uppercase fw-bold" style="font-size: .68rem; letter-spacing: .05em;">គ្រូបន្ទុកថ្នាក់</div>
                    <div class="d-flex align-items-center gap-3">
                        @if(!empty($student->schoolClass->teacher->photo))
                            <img src="{{ asset($student->schoolClass->teacher->photo) }}" alt="Teacher Profile" style="width: 38px; height: 38px; border-radius: 10px; object-fit: cover; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                        @else
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: .85rem;">
                                {{ strtoupper(substr($student->schoolClass->teacher->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="fw-bold" style="font-size: .85rem; color: var(--bs-body-color);">{{ $student->schoolClass->teacher->name }}</div>
                            <div class="small text-muted" style="font-size: .72rem;">{{ $student->schoolClass->teacher->subject ?? 'អប់រំទូទៅ' }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="d-flex gap-2">
                <a href="{{ route('student.class') }}" class="btn-outline-orange">មើលថ្នាក់រៀន</a>
                <a href="{{ route('student.subjects') }}" class="btn-fill-dark">មើលមុខវិជ្ជា</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ===== Animate Circle Progress =====
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.circle-progress-wrap').forEach(wrap => {
        const pct = parseInt(wrap.dataset.percent) || 0;
        const circle = wrap.querySelector('.circle-fill');
        const circumference = 2 * Math.PI * 55; // r=55
        const offset = circumference - (pct / 100) * circumference;
        setTimeout(() => { circle.style.strokeDashoffset = offset; }, 300);
    });
});

// ===== Calendar Widget =====
let calDate = new Date();
const monthNames = ["មករា","កុម្ភៈ","មីនា","មេសា","ឧសភា","មិថុនា","កក្កដា","សីហា","កញ្ញា","តុលា","វិច្ឆិកា","ធ្នូ"];
const dayNames = ["អា","ច","អ","ព","ព្រ","សុ","ស"];

function renderCalendar() {
    const grid = document.getElementById('calGrid');
    const label = document.getElementById('calMonthYear');
    const year = calDate.getFullYear();
    const month = calDate.getMonth();
    const today = new Date();

    label.innerHTML = `<span style="font-weight:800;">${monthNames[month]}</span> <span style="font-weight:400;color:#94a3b8;">${year}</span>`;

    let html = dayNames.map(d => `<div class="cal-day-name">${d}</div>`).join('');

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const prevDays = new Date(year, month, 0).getDate();

    for (let i = firstDay - 1; i >= 0; i--) {
        html += `<div class="cal-day other-month">${prevDays - i}</div>`;
    }
    for (let d = 1; d <= daysInMonth; d++) {
        const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
        html += `<div class="cal-day${isToday ? ' today' : ''}">${d}</div>`;
    }
    const remaining = 42 - (firstDay + daysInMonth);
    for (let i = 1; i <= remaining && (firstDay + daysInMonth + i - 1) < 42; i++) {
        html += `<div class="cal-day other-month">${i}</div>`;
    }
    grid.innerHTML = html;
}

function changeMonth(dir) {
    calDate.setMonth(calDate.getMonth() + dir);
    renderCalendar();
}

renderCalendar();
</script>
@endpush
