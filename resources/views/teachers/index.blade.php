@extends('layouts.app')
@section('title','គ្រូ')
@section('page-title','គ្រប់គ្រងគ្រូ')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h5 class="fw-700 mb-0">បញ្ជីគ្រូ</h5>
        <p class="text-muted mb-0" style="font-size:.85rem;">{{ $teachers->total() }} នាក់សរុប</p>
    </div>
    <a href="{{ route('teachers.create') }}" class="btn btn-sm btn-accent rounded-3">
        <i data-lucide="plus" class="lucide-sm me-1"></i>បន្ថែមគ្រូ
    </a>
</div>
<div class="card mb-4">
    <div class="card-body py-3 px-4">
        <form id="searchForm" method="GET" action="{{ route('teachers.index') }}" class="d-flex gap-2">
            <div class="input-group" style="max-width:400px;">
                <span class="input-group-text bg-transparent border-end-0"><i data-lucide="search" class="lucide-sm text-muted"></i></span>
                <input type="text" id="searchInput" name="search" value="{{ $search }}" class="form-control border-start-0 ps-0" placeholder="ស្វែងរក ឈ្មោះ, ID, Subject...">
            </div>
            <button type="submit" class="btn btn-primary rounded-3 px-3">ស្វែងរក</button>
            @if($search)<a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary rounded-3"><i data-lucide="x" class="lucide-sm"></i></a>@endif
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th><th>គ្រូ</th><th>Teacher ID</th><th>ភេទ</th><th>មុខវិជ្ជា</th><th>ថ្នាក់</th><th>ទូរស័ព្ទ</th><th class="pe-4 text-end">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $i => $teacher)
                    <tr>
                        <td class="ps-4 text-muted" style="font-size:.82rem;">{{ $teachers->firstItem()+$i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if(!empty($teacher->photo))
                                    <img src="{{ asset($teacher->photo) }}" alt="Teacher Profile" style="width:36px;height:36px;border-radius:10px;object-fit:cover;box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
                                @else
                                    <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;">{{ strtoupper(substr($teacher->name,0,1)) }}</div>
                                @endif
                                <div>
                                    <div class="fw-semibold" style="font-size:.9rem;">{{ $teacher->name }}</div>
                                    <div class="text-muted" style="font-size:.78rem;">{{ $teacher->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><code class="text-success">{{ $teacher->teacher_id }}</code></td>
                        <td>
                            @php $gc=match($teacher->gender){'Male'=>'badge-gender-male','Female'=>'badge-gender-female',default=>'badge-gender-other'}; @endphp
                            <span class="badge {{ $gc }} rounded-pill px-2">{{ $teacher->gender }}</span>
                        </td>
                        <td><span class="badge bg-light text-dark border rounded-pill px-2">{{ $teacher->subject }}</span></td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2">{{ $teacher->classes_count }} ថ្នាក់</span></td>
                        <td class="text-muted" style="font-size:.85rem;">{{ $teacher->phone ?? '—' }}</td>
                        <td class="pe-4 text-end">
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('teachers.show',$teacher) }}" class="btn btn-sm btn-outline-primary rounded-3"><i data-lucide="eye" class="lucide-sm"></i></a>
                                <a href="{{ route('teachers.edit',$teacher) }}" class="btn btn-sm btn-outline-warning rounded-3"><i data-lucide="pencil" class="lucide-sm"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-3" onclick="confirmDelete('{{ route('teachers.destroy',$teacher) }}','{{ $teacher->name }}')">
                                    <i data-lucide="trash-2" class="lucide-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-5 text-muted">
                        <i data-lucide="inbox" style="width:40px;height:40px;opacity:.3;" class="d-block mb-2 mx-auto"></i>
                        @if($search) រកមិនឃើញ "{{ $search }}" @else មិនទាន់មានគ្រូ — <a href="{{ route('teachers.create') }}">បន្ថែមគ្រូ</a> @endif
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($teachers->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between py-3 px-4">
        <div class="text-muted" style="font-size:.82rem;">{{ $teachers->firstItem() }}–{{ $teachers->lastItem() }} ក្នុង {{ $teachers->total() }}</div>
        {{ $teachers->links() }}
    </div>
    @endif
</div>
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body text-center p-4">
                <div class="mb-3" style="font-size:3rem;">🗑️</div>
                <h5 class="fw-700">តើអ្នកចង់លុបមែនទេ?</h5>
                <p class="text-muted mb-4" id="deleteTeacherName"></p>
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
    document.getElementById('deleteTeacherName').textContent = 'គ្រូ "' + name + '" នឹងត្រូវបានលុបជាអចិន្ត្រៃ។';
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Dynamic Search
let searchTimeout;
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    if (searchInput.value) {
        const len = searchInput.value.length;
        searchInput.setSelectionRange(len, len);
        searchInput.focus();
    }
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('searchForm').submit();
        }, 500);
    });
}
</script>
@endpush
