@extends('layouts.app')

@section('title', 'កត់ត្រាវត្តមានសិស្ស')
@section('page-title', 'ការគ្រប់គ្រងវត្តមាន')

@push('styles')
<style>
/* ===== Page Animation & Layout ===== */
.animate-fade-in {
    animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== Week Navigator ===== */
.week-navigator-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    padding: 1.25rem 1.75rem;
    box-shadow: var(--card-shadow);
    margin-bottom: 2rem;
}
.week-nav-btn {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--bs-border-color, #e2e8f0);
    background: transparent;
    color: var(--bs-body-color);
    transition: all 0.2s ease;
}
.week-nav-btn:hover {
    background: var(--bs-secondary-bg, #f8fafc);
    color: var(--accent, #6366f1);
    border-color: var(--accent, #6366f1);
    transform: scale(1.05);
}

/* ===== Weekly Columns Grid ===== */
.weekly-schedule-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}
@media (max-width: 1200px) {
    .weekly-schedule-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
@media (max-width: 768px) {
    .weekly-schedule-grid {
        grid-template-columns: 1fr;
    }
}

.day-column {
    background: rgba(var(--bs-tertiary-bg-rgb), 0.4);
    border: 1px dashed var(--bs-border-color, #cbd5e1);
    border-radius: 20px;
    padding: 1rem;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.day-column-header {
    text-align: center;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--bs-border-color, #e2e8f0);
    margin-bottom: 0.25rem;
}
.day-column-header h6 {
    font-weight: 700;
    margin-bottom: 0.15rem;
    color: var(--bs-body-color);
}
.day-column-header span {
    font-size: 0.75rem;
    color: #94a3b8;
    font-weight: 600;
}

/* ===== Session Cards ===== */
.session-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 16px;
    padding: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.015);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    cursor: pointer;
    overflow: hidden;
}
.session-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    border-color: var(--accent, #6366f1);
}
.session-card.active {
    border: 2px solid var(--accent, #6366f1);
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15);
    background: linear-gradient(to bottom, var(--bs-card-bg, #fff), rgba(99, 102, 241, 0.02));
}
.session-card.active::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--accent, #6366f1);
}

.session-subject {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--bs-body-color);
    margin-bottom: 0.35rem;
    line-height: 1.3;
}
.session-meta-row {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}
.session-meta-row i {
    opacity: 0.7;
}

/* ===== Badges ===== */
.session-badge {
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.25rem 0.6rem;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.5rem;
}
.badge-pending {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.2);
}
.badge-checked {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

/* ===== Student Attendance Sheet ===== */
.student-sheet-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--card-shadow);
}

/* HSL Tailored radio tiles */
.radio-tile-group {
    display: flex;
    gap: 0.4rem;
    justify-content: center;
}
.radio-tile-group .btn-check:checked + .btn-outline-success {
    background-color: #10b981 !important;
    color: #fff !important;
    border-color: #10b981 !important;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}
.radio-tile-group .btn-check:checked + .btn-outline-danger {
    background-color: #ef4444 !important;
    color: #fff !important;
    border-color: #ef4444 !important;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
}
.radio-tile-group .btn-check:checked + .btn-outline-warning {
    background-color: #f59e0b !important;
    color: #fff !important;
    border-color: #f59e0b !important;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
}
.radio-tile-group .btn {
    font-size: 0.78rem;
    font-weight: 700;
    border-radius: 10px;
    padding: 0.4rem 0.75rem;
    min-width: 80px;
    border-width: 1.5px;
    transition: all 0.2s ease;
}
.radio-tile-group .btn:hover {
    transform: scale(1.02);
}

.student-table th {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    padding: 1rem 0.75rem;
}
.student-table td {
    padding: 1rem 0.75rem;
}
</style>
@endpush

@section('content')
@php
    $prevWeek = \Carbon\Carbon::parse($selectedWeekStart)->subWeek()->toDateString();
    $nextWeek = \Carbon\Carbon::parse($selectedWeekStart)->addWeek()->toDateString();
    $formattedWeekRange = \Carbon\Carbon::parse($selectedWeekStart)->format('M d') . ' - ' . \Carbon\Carbon::parse($selectedWeekStart)->addDays(4)->format('M d, Y');
    
    // Day Translations
    $dayTrans = [
        'Monday' => 'ចន្ទ (Mon)',
        'Tuesday' => 'អង្គារ (Tue)',
        'Wednesday' => 'ពុធ (Wed)',
        'Thursday' => 'ព្រហស្បតិ៍ (Thu)',
        'Friday' => 'សុក្រ (Fri)'
    ];
@endphp

<div class="row animate-fade-in">
    <div class="col-12">
        {{-- 1. Week Navigator Header --}}
        <div class="week-navigator-card">
            <div class="row align-items-center g-3">
                <div class="col-md-6 d-flex align-items-center gap-3">
                    <div style="width: 52px; height: 52px; background: rgba(99,102,241,0.1); color: var(--accent); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="calendar-days" class="lucide-lg"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--bs-body-color);">កាលវិភាគប្រចាំសប្តាហ៍</h4>
                        <p class="text-muted small mb-0">ជ្រើសរើសកាតវគ្គសិក្សាខាងក្រោម ដើម្បីគ្រប់គ្រងវត្តមានសិស្ស។</p>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end justify-content-start align-items-center gap-3">
                    <a href="{{ route('teacher.attendance', ['week_start' => $prevWeek]) }}" class="week-nav-btn" title="Previous Week">
                        <i data-lucide="chevron-left"></i>
                    </a>
                    <div class="text-center px-3">
                        <span class="small fw-bold text-muted d-block text-uppercase" style="letter-spacing: 0.05em;">សប្តាហ៍ដែលបានជ្រើសរើស</span>
                        <span class="fw-bold fs-5" style="color: var(--bs-body-color);">{{ $formattedWeekRange }}</span>
                    </div>
                    <a href="{{ route('teacher.attendance', ['week_start' => $nextWeek]) }}" class="week-nav-btn" title="Next Week">
                        <i data-lucide="chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- 2. Monday to Friday Columns Grid --}}
        <div class="weekly-schedule-grid">
            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                <div class="day-column">
                    <div class="day-column-header">
                        <h6>{{ $dayTrans[$day] }}</h6>
                        <span>{{ \Carbon\Carbon::parse($weekDates[$day])->format('M d, Y') }}</span>
                    </div>
                    
                    @forelse($schedule[$day] ?? [] as $session)
                        @php
                            $isActive = ($selectedClassId == $session['class_id'] && $selectedCourseId == $session['course_id'] && $selectedDate == $session['date']);
                        @endphp
                        
                        <a href="{{ route('teacher.attendance', ['class_id' => $session['class_id'], 'course_id' => $session['course_id'], 'attendance_date' => $session['date'], 'week_start' => $selectedWeekStart]) }}" class="text-decoration-none">
                            <div class="session-card {{ $isActive ? 'active' : '' }}">
                                <div class="session-subject">{{ $session['course_name'] }}</div>
                                
                                <div class="session-meta-row mt-2">
                                    <i data-lucide="building-2" class="lucide-sm text-indigo"></i>
                                    <span class="fw-bold text-dark">{{ $session['class_name'] }}</span>
                                </div>
                                <div class="session-meta-row">
                                    <i data-lucide="clock" class="lucide-sm"></i>
                                    <span>{{ $session['time_label'] }}</span>
                                </div>
                                <div class="session-meta-row">
                                    <i data-lucide="map-pin" class="lucide-sm"></i>
                                    <span>បន្ទប់ {{ $session['room_number'] ?? 'N/A' }}</span>
                                </div>
                                
                                @if($session['is_checked'])
                                    <div class="session-badge badge-checked">
                                        <i data-lucide="check" class="lucide-sm"></i> បានពិនិត្យរួច
                                    </div>
                                @else
                                    <div class="session-badge badge-pending">
                                        <i data-lucide="clock" class="lucide-sm"></i> រង់ចាំត្រួតពិនិត្យ
                                    </div>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="text-center text-muted py-4">
                            <span class="small">គ្មានម៉ោងសិក្សា</span>
                        </div>
                    @endforelse
                </div>
            @endforeach
        </div>

        {{-- 3. Student Attendance Sheet --}}
        @if($selectedClassId && $selectedCourseId && $selectedDate)
            <div class="student-sheet-card">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold mb-1" style="color: var(--bs-body-color);"><i data-lucide="clipboard-list" class="me-2 text-primary"></i> បញ្ជីវត្តមានសិស្ស</h5>
                        <p class="text-muted small mb-0">កាលបរិច្ឆេទម៉ោងសិក្សា៖ <strong>{{ \Carbon\Carbon::parse($selectedDate)->format('d-M-Y') }}</strong></p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-success btn-sm rounded-3 fw-bold" id="markAllPresentBtn">
                            <i data-lucide="check" class="lucide-sm me-1"></i> វត្តមានទាំងអស់
                        </button>
                        @if($students->count() > 0)
                            <a href="{{ route('teacher.attendance.export', ['class_id' => $selectedClassId, 'course_id' => $selectedCourseId, 'attendance_date' => $selectedDate]) }}" class="btn btn-outline-primary btn-sm rounded-3 fw-bold">
                                <i data-lucide="download" class="lucide-sm me-1"></i> ទាញយកជា Excel
                            </a>
                        @endif
                    </div>
                </div>

                <form method="POST" action="{{ route('teacher.attendance.store') }}">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                    <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
                    <input type="hidden" name="attendance_date" value="{{ $selectedDate }}">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle student-table">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">រូបថត</th>
                                    <th style="width: 140px;">អត្តលេខសិស្ស</th>
                                    <th>ឈ្មោះពេញ</th>
                                    <th style="width: 120px;">ភេទ</th>
                                    <th class="text-center" style="width: 320px;">ស្ថានភាព</th>
                                    <th>កំណត់សម្គាល់</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    @php
                                        $att = $existingAttendances->get($student->id);
                                        $status = $att ? $att->status : 'present';
                                        $remark = $att ? $att->remarks : '';
                                    @endphp
                                    <tr>
                                        <td>
                                            @if($student->photo)
                                                <img src="{{ asset('storage/' . $student->photo) }}" alt="Profile" class="avatar-sm border" style="border-radius: 12px; width: 44px; height: 44px; object-fit: cover;">
                                            @else
                                                <div class="avatar-sm border d-flex align-items-center justify-content-center fw-bold bg-light text-primary" style="border-radius: 12px; width: 44px; height: 44px;">
                                                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td><code class="small text-secondary fw-semibold">{{ $student->student_id }}</code></td>
                                        <td>
                                            <div class="fw-bold">{{ $student->full_name }}</div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $student->gender === 'Male' ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }} px-2.5 py-1.5" style="font-weight: 600;">
                                                {{ $student->gender === 'Male' ? 'ប្រុស' : ($student->gender === 'Female' ? 'ស្រី' : $student->gender) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="radio-tile-group">
                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="pres_{{ $student->id }}" value="present" {{ $status === 'present' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success" for="pres_{{ $student->id }}"><i data-lucide="check" class="lucide-sm me-1"></i>វត្តមាន</label>

                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="late_{{ $student->id }}" value="late" {{ $status === 'late' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning" for="late_{{ $student->id }}"><i data-lucide="clock" class="lucide-sm me-1"></i>យឺត</label>

                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="abs_{{ $student->id }}" value="absent" {{ $status === 'absent' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger" for="abs_{{ $student->id }}"><i data-lucide="x" class="lucide-sm me-1"></i>អវត្តមាន</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="remarks[{{ $student->id }}]" class="form-control form-control-md" style="border-radius:10px; font-size: 0.85rem;" placeholder="ឧ. ឈឺ, ច្បាប់" value="{{ $remark }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i data-lucide="users" class="lucide-2xl mb-2 text-secondary" style="opacity: 0.3;"></i>
                                            <p class="mb-0 fw-bold">មិនទាន់មានសិស្សចុះឈ្មោះក្នុងថ្នាក់នេះនៅឡើយទេ។</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($students->count() > 0)
                        <div class="d-flex justify-content-end mt-4 border-top pt-4">
                            <button type="submit" class="btn btn-accent px-5 py-3 d-flex align-items-center gap-2" style="border-radius: 14px; font-weight: 700; font-size: 0.95rem; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);">
                                <i data-lucide="save" class="lucide-md"></i> រក្សាទុកវត្តមាន
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        @else
            <div class="student-sheet-card text-center py-5 text-muted">
                <i data-lucide="clipboard-check" class="lucide-2xl mb-3" style="opacity: .2;"></i>
                <h5 class="fw-bold">មិនទាន់មានថ្នាក់ដែលបានជ្រើសរើស</h5>
                <p class="mb-0 small">សូមចុចលើកាតកាលវិភាគណាមួយខាងលើ ដើម្បីបង្ហាញបញ្ជីវត្តមានសិស្ស។</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark All Present button
    const markAllPresentBtn = document.getElementById('markAllPresentBtn');
    if (markAllPresentBtn) {
        markAllPresentBtn.addEventListener('click', function() {
            // Find all 'present' radio buttons and check them
            const presentRadios = document.querySelectorAll('input[type="radio"][value="present"]');
            presentRadios.forEach(radio => {
                radio.checked = true;
            });
        });
    }
});
</script>
@endpush
