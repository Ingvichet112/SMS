@extends('layouts.app')
@section('title',$teacher->name)
@section('page-title','ព័ត៌មានគ្រូ')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-outline-secondary rounded-3"><i class="bi bi-arrow-left"></i></a>
        <h5 class="fw-700 mb-0">{{ $teacher->name }}</h5>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('teachers.edit',$teacher) }}" class="btn btn-sm btn-warning rounded-3"><i class="bi bi-pencil me-1"></i>កែប្រែ</a>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body p-4">
                <div style="width:80px;height:80px;border-radius:20px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:2rem;margin:0 auto 1rem;">
                    {{ strtoupper(substr($teacher->name,0,1)) }}
                </div>
                <h5 class="fw-700 mb-1">{{ $teacher->name }}</h5>
                <code class="text-success d-block mb-2">{{ $teacher->teacher_id }}</code>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{ $teacher->subject }}</span>
                <div class="mt-3 p-3 rounded-3 text-start" style="background:rgba(16,185,129,.08);">
                    <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;">ថ្នាក់ {{ $teacher->classes->count() }} ថ្នាក់</div>
                    @foreach($teacher->classes as $cls)
                        <div class="d-flex align-items-center justify-content-between py-1 border-bottom" style="font-size:.85rem;">
                            <span>{{ $cls->class_name }}</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $cls->students->count() }} នាក់</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i class="bi bi-info-circle me-2"></i>ព័ត៌មានលម្អិត</h6></div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @php $fields=[
                        ['label'=>'ភេទ','icon'=>'bi-person','value'=>$teacher->gender],
                        ['label'=>'អ៊ីមែល','icon'=>'bi-envelope','value'=>$teacher->email],
                        ['label'=>'ទូរស័ព្ទ','icon'=>'bi-phone','value'=>$teacher->phone],
                        ['label'=>'អាសយដ្ឋាន','icon'=>'bi-geo-alt','value'=>$teacher->address],
                        ['label'=>'បង្កើតនៅ','icon'=>'bi-clock','value'=>$teacher->created_at->format('d M Y')],
                    ]; @endphp
                    @foreach($fields as $f)
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:var(--bs-secondary-bg,#f8fafc);">
                            <div class="text-muted mb-1" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;"><i class="bi {{ $f['icon'] }} me-1"></i>{{ $f['label'] }}</div>
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
