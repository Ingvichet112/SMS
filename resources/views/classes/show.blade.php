@extends('layouts.app')
@section('title',$class->class_name)
@section('page-title','ព័ត៌មានថ្នាក់')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('classes.index') }}" class="btn btn-sm btn-outline-secondary rounded-3"><i data-lucide="arrow-left" class="lucide-sm"></i></a>
        <h5 class="fw-700 mb-0">{{ $class->class_name }}</h5>
    </div>
    <a href="{{ route('classes.edit',$class) }}" class="btn btn-sm btn-warning rounded-3"><i data-lucide="pencil" class="lucide-sm me-1"></i>កែប្រែ</a>
</div>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body p-4">
                <div style="width:72px;height:72px;border-radius:20px;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <i data-lucide="building-2" style="width:32px;height:32px;stroke:#fff;"></i>
                </div>
                <h5 class="fw-700 mb-1">{{ $class->class_name }}</h5>
                @if($class->room_number)<p class="text-muted mb-3"><i data-lucide="map-pin" class="lucide-sm me-1"></i>Room {{ $class->room_number }}</p>@endif
                @if($class->teacher)
                <div class="p-3 rounded-3 text-start mb-3" style="background:rgba(16,185,129,.08);">
                    <div class="text-muted mb-1" style="font-size:.72rem;text-transform:uppercase;">គ្រូ</div>
                    <div class="fw-600">{{ $class->teacher->name }}</div>
                    <div class="text-muted" style="font-size:.8rem;">{{ $class->teacher->subject }}</div>
                </div>
                @endif
                <div class="p-3 rounded-3" style="background:rgba(99,102,241,.08);">
                    <div style="font-size:2rem;font-weight:700;color:#6366f1;">{{ $class->students->count() }}</div>
                    <div class="text-muted" style="font-size:.8rem;">សិស្សសរុប</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="users" class="lucide-sm me-2"></i>សិស្សក្នុងថ្នាក់</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr><th class="ps-4">#</th><th>សិស្ស</th><th>ID</th><th>ភេទ</th><th class="pe-4"></th></tr>
                        </thead>
                        <tbody>
                            @forelse($class->students as $i => $student)
                            <tr>
                                <td class="ps-4 text-muted" style="font-size:.82rem;">{{ $i+1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $student->photo_url }}" class="avatar-sm">
                                        <span class="fw-500">{{ $student->full_name }}</span>
                                    </div>
                                </td>
                                <td><code class="text-primary">{{ $student->student_id }}</code></td>
                                <td>
                                    @php $gc=match($student->gender){'Male'=>'badge-gender-male','Female'=>'badge-gender-female',default=>'badge-gender-other'}; @endphp
                                    <span class="badge {{ $gc }} rounded-pill px-2">{{ $student->gender }}</span>
                                </td>
                                <td class="pe-4"><a href="{{ route('students.show',$student) }}" class="btn btn-sm btn-outline-primary rounded-3"><i data-lucide="eye" class="lucide-sm"></i></a></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">មិនទាន់មានសិស្ស</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
