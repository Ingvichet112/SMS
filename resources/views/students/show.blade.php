@extends('layouts.app')
@section('title',$student->full_name)
@section('page-title','ព័ត៌មានសិស្ស')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary rounded-3"><i data-lucide="arrow-left" class="lucide-sm"></i></a>
        <h5 class="fw-700 mb-0">{{ $student->full_name }}</h5>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('students.edit',$student) }}" class="btn btn-sm btn-warning rounded-3"><i data-lucide="pencil" class="lucide-sm me-1"></i>កែប្រែ</a>
        <button type="button" class="btn btn-sm btn-danger rounded-3" onclick="document.getElementById('delForm').submit()">
            <i data-lucide="trash-2" class="lucide-sm me-1"></i>លុប
        </button>
        <form id="delForm" method="POST" action="{{ route('students.destroy',$student) }}" class="d-none">@csrf @method('DELETE')</form>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body p-4">
                <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}" style="width:120px;height:120px;border-radius:20px;object-fit:cover;margin-bottom:1rem;">
                <h5 class="fw-700 mb-1">{{ $student->full_name }}</h5>
                <code class="text-primary d-block mb-2">{{ $student->student_id }}</code>
                @php $gc=match($student->gender){'Male'=>'badge-gender-male','Female'=>'badge-gender-female',default=>'badge-gender-other'}; @endphp
                <span class="badge {{ $gc }} rounded-pill px-3 py-2">{{ $student->gender }}</span>
                @if($student->schoolClass)
                    <div class="mt-3 p-3 rounded-3" style="background:rgba(99,102,241,.08);">
                        <div class="text-muted" style="font-size:.75rem;text-transform:uppercase;">ថ្នាក់</div>
                        <div class="fw-600">{{ $student->schoolClass->class_name }}</div>
                        @if($student->schoolClass->teacher)
                            <div class="text-muted" style="font-size:.8rem;"><i data-lucide="user" class="lucide-sm me-1"></i>{{ $student->schoolClass->teacher->name }}</div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="info" class="lucide-sm me-2"></i>ព័ត៌មានលម្អិត</h6></div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @php $fields=[
                        ['label'=>'ថ្ងៃខែឆ្នាំកំណើត','icon'=>'calendar','value'=>$student->date_of_birth?->format('d M Y').' ('.($student->age??'?').' ឆ្នាំ)'],
                        ['label'=>'អ៊ីមែល','icon'=>'mail','value'=>$student->email],
                        ['label'=>'ទូរស័ព្ទ','icon'=>'phone','value'=>$student->phone],
                        ['label'=>'អាសយដ្ឋាន','icon'=>'map-pin','value'=>$student->address],
                        ['label'=>'បង្កើតនៅ','icon'=>'clock','value'=>$student->created_at->format('d M Y H:i')],
                    ]; @endphp
                    @foreach($fields as $f)
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:var(--bs-secondary-bg,#f8fafc);">
                            <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;">
                                <i data-lucide="{{ $f['icon'] }}" class="lucide-sm me-1"></i>{{ $f['label'] }}
                            </div>
                            <div class="fw-500" style="font-size:.9rem;">{{ $f['value'] ?? '—' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
