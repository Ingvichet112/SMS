@extends('layouts.app')

@section('title', 'បញ្ចូលពិន្ទុសិស្ស')
@section('page-title', 'ការគ្រប់គ្រងពិន្ទុ')

@push('styles')
<style>
.filter-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.02);
    margin-bottom: 2rem;
}
.student-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.02);
}
.score-input {
    width: 100px;
    font-weight: 700;
    text-align: center;
    border-radius: 10px;
}
.score-input:focus {
    box-shadow: 0 0 0 3px rgba(99,102,241,0.25);
    border-color: #6366f1;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Filters Section --}}
        <div class="filter-card">
            <h5 class="fw-bold mb-3" style="color: var(--bs-body-color);"><i data-lucide="filter" class="me-2 text-primary"></i> ជ្រើសរើសតម្រង</h5>
            <form method="GET" action="{{ route('teacher.scores') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">ថ្នាក់រៀន</label>
                    <input type="text" class="form-control form-control-md" style="border-radius:12px; background-color: var(--bs-secondary-bg, #f8fafc);" value="{{ $classes->first()->class_name ?? 'មិនទាន់មានថ្នាក់ចាត់ចែង' }}" readonly>
                    <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">មុខវិជ្ជា</label>
                    <select name="course_id" class="form-select form-select-md" style="border-radius:12px;" required>
                        <option value="">-- ជ្រើសរើសមុខវិជ្ជា --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-bold">ឆមាស</label>
                    <select name="semester" class="form-select form-select-md" style="border-radius:12px;" required>
                        <option value="Semester 1" {{ $selectedSemester === 'Semester 1' ? 'selected' : '' }}>ឆមាសទី ១</option>
                        <option value="Semester 2" {{ $selectedSemester === 'Semester 2' ? 'selected' : '' }}>ឆមាសទី ២</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6 text-end d-flex align-items-end gap-2">
                    <div class="flex-grow-1 text-start">
                        <label class="form-label small fw-bold">ឆ្នាំសិក្សា</label>
                        <select name="academic_year" class="form-select form-select-md" style="border-radius:12px;" required>
                            <option value="2023-2024" {{ $selectedAcademicYear === '2023-2024' ? 'selected' : '' }}>2023-2024</option>
                            <option value="2024-2025" {{ $selectedAcademicYear === '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-accent py-2.5 d-flex align-items-center justify-content-center gap-2 px-4" style="border-radius:12px; font-weight:600; height: 46px;">
                        <i data-lucide="search" class="lucide-sm"></i> ទាញយក
                    </button>
                </div>
            </form>
        </div>

        {{-- Students Score Entry Section --}}
        @if($selectedClassId && $selectedCourseId)
            <div class="student-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1"><i data-lucide="award" class="me-2 text-success"></i> បញ្ជីបញ្ចូលពិន្ទុ</h5>
                        <p class="text-muted small mb-0">កត់ត្រា ឬកែសម្រួលពិន្ទុសិស្សសម្រាប់មុខវិជ្ជា និងឆមាសសកម្ម។ ទុកចោលទទេដើម្បីលុបពិន្ទុ។</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('teacher.scores.store') }}">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                    <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
                    <input type="hidden" name="semester" value="{{ $selectedSemester }}">
                    <input type="hidden" name="academic_year" value="{{ $selectedAcademicYear }}">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">រូបថត</th>
                                    <th>អត្តលេខ</th>
                                    <th>ឈ្មោះពេញ</th>
                                    <th>ភេទ</th>
                                    <th class="text-center" style="width: 150px;">ពិន្ទុ (0-100)</th>
                                    <th class="text-center" style="width: 120px;">និទ្ទេស</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    @php
                                        $mark = $existingMarks->get($student->id);
                                        $score = $mark ? $mark->score : '';
                                        $grade = $mark ? $mark->grade : '-';
                                        $color = $mark ? $mark->grade_color : '#94a3b8';
                                    @endphp
                                    <tr>
                                        <td>
                                            <img src="{{ $student->photo_url }}" alt="Profile" class="avatar-sm">
                                        </td>
                                        <td><code class="small text-secondary">{{ $student->student_id }}</code></td>
                                        <td>
                                            <div class="fw-bold">{{ $student->full_name }}</div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $student->gender === 'Male' ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' }} px-2.5 py-1.5" style="font-weight:600;">
                                                {{ $student->gender === 'Male' ? 'ប្រុស' : ($student->gender === 'Female' ? 'ស្រី' : $student->gender) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" name="scores[{{ $student->id }}]" class="form-control score-input mx-auto" min="0" max="100" step="0.1" value="{{ $score }}" placeholder="-">
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-extrabold fs-5" style="color: {{ $color }};">{{ $grade }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i data-lucide="users" class="lucide-2xl mb-2" style="opacity: 0.3;"></i>
                                            <p class="mb-0">មិនទាន់មានសិស្សក្នុងថ្នាក់នេះនៅឡើយទេ។</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($students->count() > 0)
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-accent px-5 py-2.5 d-flex align-items-center gap-2" style="border-radius:12px; font-weight:700;">
                                <i data-lucide="save" class="lucide-md"></i> រក្សាទុកពិន្ទុ
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        @else
            <div class="student-card text-center py-5 text-muted">
                <i data-lucide="award" class="lucide-2xl mb-2" style="opacity: .2;"></i>
                <h6 class="fw-bold">មិនទាន់មានបញ្ជីទាញយកឡើយ</h6>
                <p class="mb-0 small">សូមជ្រើសរើស ថ្នាក់ មុខវិជ្ជា និងតម្រងផ្សេងទៀតខាងលើ រួចចុច "Load"។</p>
            </div>
        @endif
    </div>
</div>
@endsection
