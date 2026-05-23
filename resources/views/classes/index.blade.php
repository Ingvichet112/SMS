@extends('layouts.app')
@section('title','ថ្នាក់រៀន')
@section('page-title','គ្រប់គ្រងថ្នាក់រៀន')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h5 class="fw-700 mb-0">បញ្ជីថ្នាក់រៀន</h5>
        <p class="text-muted mb-0" style="font-size:.85rem;">{{ $classes->total() }} ថ្នាក់សរុប</p>
    </div>
    <a href="{{ route('classes.create') }}" class="btn btn-sm btn-accent rounded-3"><i data-lucide="plus" class="lucide-sm me-1"></i>បន្ថែមថ្នាក់</a>
</div>
<div class="card mb-4">
    <div class="card-body py-3 px-4">
        <form id="searchForm" method="GET" action="{{ route('classes.index') }}" class="d-flex gap-2">
            <div class="input-group" style="max-width:400px;">
                <span class="input-group-text bg-transparent border-end-0"><i data-lucide="search" class="lucide-sm text-muted"></i></span>
                <input type="text" id="searchInput" name="search" value="{{ $search }}" class="form-control border-start-0 ps-0" placeholder="ស្វែងរក ថ្នាក់, បន្ទប់...">
            </div>
            <button type="submit" class="btn btn-primary rounded-3 px-3">ស្វែងរក</button>
            @if($search)<a href="{{ route('classes.index') }}" class="btn btn-outline-secondary rounded-3"><i data-lucide="x" class="lucide-sm"></i></a>@endif
        </form>
    </div>
</div>
<div class="row g-4">
    @forelse($classes as $class)
    <div class="col-md-6 col-xl-4">
        <div class="card h-100" style="transition:transform .2s,box-shadow .2s; cursor:pointer;" onclick="window.location='{{ route('classes.show',$class) }}'" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,.1)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-3">
                        @if($class->teacher)
                            @if(!empty($class->teacher->photo))
                                <img src="{{ asset($class->teacher->photo) }}" alt="Teacher Profile" style="width:48px;height:48px;border-radius:14px;object-fit:cover;box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                            @else
                                <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1.15rem;box-shadow: 0 4px 12px rgba(16,185,129,0.2);">
                                    {{ strtoupper(substr($class->teacher->name, 0, 1)) }}
                                </div>
                            @endif
                        @else
                            <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;color:#fff;">
                                <i data-lucide="building-2" style="width:22px;height:22px;stroke:#fff;"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-700 mb-0">{{ $class->class_name }}</h6>
                            @if($class->room_number)<small class="text-muted"><i data-lucide="map-pin" class="lucide-sm me-1"></i>Room {{ $class->room_number }}</small>@endif
                        </div>
                    </div>
                    <div class="dropdown" onclick="event.stopPropagation()">
                        <button class="btn btn-sm btn-outline-secondary rounded-3" data-bs-toggle="dropdown"><i data-lucide="more-vertical" class="lucide-sm"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('classes.edit',$class) }}"><i data-lucide="pencil" class="lucide-sm me-2"></i>កែប្រែ</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item text-danger" onclick="confirmDelete('{{ route('classes.destroy',$class) }}','{{ $class->class_name }}')"><i data-lucide="trash-2" class="lucide-sm me-2"></i>លុប</button></li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <div class="text-center flex-fill p-2 rounded-3" style="background:rgba(99,102,241,.08);">
                        <div style="font-size:1.25rem;font-weight:700;color:#6366f1;">{{ $class->students_count }}</div>
                        <div class="text-muted" style="font-size:.72rem;">សិស្ស</div>
                    </div>
                    <div class="flex-fill p-2 rounded-3" style="background:rgba(16,185,129,.08);">
                        <div class="text-muted mb-0" style="font-size:.72rem;">គ្រូ</div>
                        <div class="fw-600" style="font-size:.85rem;color:#10b981;">{{ $class->teacher?->name ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12"><div class="card text-center py-5"><div class="card-body">
        <i data-lucide="inbox" style="width:48px;height:48px;opacity:.3;" class="d-block mb-2 mx-auto"></i>
        @if($search) រកមិនឃើញ "{{ $search }}" @else មិនទាន់មានថ្នាក់ — <a href="{{ route('classes.create') }}">បន្ថែមថ្នាក់</a> @endif
    </div></div></div>
    @endforelse
</div>
@if($classes->hasPages())<div class="mt-4 d-flex justify-content-center">{{ $classes->links() }}</div>@endif
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body text-center p-4">
                <div class="mb-3" style="font-size:3rem;">🗑️</div>
                <h5 class="fw-700">តើអ្នកចង់លុបមែនទេ?</h5>
                <p class="text-muted mb-4" id="deleteClassName"></p>
                <div class="d-flex gap-3 justify-content-center">
                    <button class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">បោះបង់</button>
                    <form id="deleteForm" method="POST">@csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-3 px-4"><i data-lucide="trash-2" class="lucide-sm me-1"></i>លុប</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function confirmDelete(url, name) {
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteClassName').textContent = 'ថ្នាក់ "' + name + '" នឹងត្រូវបានលុបជាអចិន្ត្រៃ។';
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Dynamic Search
let searchTimeout;
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    // Focus cursor at the end of the input if there's a value
    if (searchInput.value) {
        const len = searchInput.value.length;
        searchInput.setSelectionRange(len, len);
        searchInput.focus();
    }
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500); // Wait 500ms after typing stops before submitting
    });
}
</script>
@endpush
