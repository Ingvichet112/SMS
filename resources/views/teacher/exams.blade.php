@extends('layouts.app')

@section('title', 'គ្រប់គ្រងកាលវិភាគប្រឡង')
@section('page-title', 'កាលវិភាគប្រឡង')

@push('styles')
<style>
.exam-form-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.02);
}
.exam-list-card {
    background: var(--bs-card-bg, #fff);
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.02);
}
.exam-badge {
    background: rgba(234, 88, 12, 0.1);
    color: #ea580c;
    font-weight: 700;
    font-size: .78rem;
    padding: .35rem .75rem;
    border-radius: 8px;
}
</style>
@endpush

@section('content')
<div class="row g-4">
    {{-- Left: Create Schedule Form --}}
    <div class="col-lg-4">
        <div class="exam-form-card">
            <h5 class="fw-bold mb-3"><i data-lucide="plus-circle" class="me-2 text-primary"></i> បង្កើតកាលវិភាគប្រឡង</h5>
            <p class="text-muted small mb-4">កំណត់កាលបរិច្ឆេទ ពេលវេលា និងបន្ទប់ប្រឡងថ្មីសម្រាប់ថ្នាក់ និងមុខវិជ្ជា។</p>

            <form method="POST" action="{{ route('teacher.exams.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">ថ្នាក់រៀន</label>
                    <input type="text" class="form-control" style="border-radius: 10px; background-color: var(--bs-secondary-bg, #f8fafc);" value="{{ $classes->first()->class_name ?? 'មិនទាន់មានថ្នាក់ចាត់ចែង' }}" readonly>
                    <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">មុខវិជ្ជា</label>
                    <select name="course_id" class="form-select" style="border-radius: 10px;" required>
                        <option value="">-- ជ្រើសរើសមុខវិជ្ជា --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">ឈ្មោះការប្រឡង</label>
                    <input type="text" name="exam_name" class="form-control" style="border-radius: 10px;" placeholder="ឧ. ពាក់កណ្តាលឆមាស, ឆមាស, តេស្តប្រចាំខែ" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">កាលបរិច្ឆេទប្រឡង</label>
                    <input type="date" name="exam_date" class="form-control" style="border-radius: 10px;" required>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">ម៉ោងចាប់ផ្តើម</label>
                        <input type="time" name="start_time" class="form-control" style="border-radius: 10px;" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">ម៉ោងបញ្ចប់</label>
                        <input type="time" name="end_time" class="form-control" style="border-radius: 10px;" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">បន្ទប់</label>
                    <input type="text" name="room" class="form-control" style="border-radius: 10px;" placeholder="ឧ. បន្ទប់ ៣០១, បន្ទប់ពិសោធន៍ B">
                </div>

                <button type="submit" class="btn btn-accent w-100 py-2.5 d-flex align-items-center justify-content-center gap-2" style="border-radius: 12px; font-weight:700;">
                    <i data-lucide="plus" class="lucide-md"></i> បង្កើតកាលវិភាគ
                </button>
            </form>
        </div>
    </div>

    {{-- Right: Current Exam Schedules List --}}
    <div class="col-lg-8">
        <div class="exam-list-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1"><i data-lucide="calendar-clock" class="me-2 text-success"></i> ការប្រឡងដែលបានកំណត់</h5>
                    <p class="text-muted small mb-0">បញ្ជីកាលបរិច្ឆេទ និងពេលវេលាប្រឡងដែលបានកំណត់សម្រាប់ថ្នាក់របស់អ្នក។</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ឈ្មោះការប្រឡង</th>
                            <th>មុខវិជ្ជា</th>
                            <th>ថ្នាក់រៀន</th>
                            <th>កាលបរិច្ឆេទ</th>
                            <th>ពេលវេលា</th>
                            <th>បន្ទប់</th>
                            <th class="text-end" style="width: 100px;">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                            <tr>
                                <td><span class="exam-badge">{{ $exam->exam_name }}</span></td>
                                <td><div class="fw-bold">{{ $exam->course->course_name }}</div></td>
                                <td><span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5">{{ $exam->schoolClass->class_name }}</span></td>
                                <td>
                                    <span class="small fw-semibold"><i data-lucide="calendar" class="lucide-sm me-1 text-muted"></i>{{ $exam->exam_date->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="small text-muted"><i data-lucide="clock" class="lucide-sm me-1"></i>{{ substr($exam->start_time, 0, 5) }} - {{ substr($exam->end_time, 0, 5) }}</span>
                                </td>
                                <td>
                                    <span class="small fw-bold"><i data-lucide="map-pin" class="lucide-sm me-1 text-muted"></i>{{ $exam->room ?? 'N/A' }}</span>
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('teacher.exams.destroy', $exam->id) }}" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបកាលវិភាគនេះមែនទេ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" title="លុបកាលវិភាគ">
                                            <i data-lucide="trash-2" class="lucide-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i data-lucide="calendar-x" class="lucide-2xl mb-2" style="opacity: 0.3;"></i>
                                    <p class="mb-0">រកមិនឃើញកាលវិភាគប្រឡងឡើយ។</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
