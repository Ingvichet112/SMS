@extends('layouts.app')
@section('title','បន្ថែមសិស្ស')
@section('page-title','បន្ថែមសិស្ស')
@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary rounded-3"><i data-lucide="arrow-left" class="lucide-sm"></i></a>
    <h5 class="fw-700 mb-0">បន្ថែមសិស្សថ្មី</h5>
</div>
<form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="user" class="lucide-sm me-2"></i>ព័ត៌មានសិស្ស</h6></div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Student ID <span class="text-danger">*</span></label>
                            <input type="text" name="student_id" value="{{ old('student_id') }}" class="form-control rounded-3 @error('student_id') is-invalid @enderror" placeholder="STU-001">
                            @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ភេទ <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select rounded-3 @error('gender') is-invalid @enderror">
                                <option value="">— ជ្រើសរើស —</option>
                                @foreach(['Male','Female','Other'] as $g)<option value="{{ $g }}" {{ old('gender')==$g?'selected':'' }}>{{ $g }}</option>@endforeach
                            </select>
                            @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">នាមត្រកូល <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control rounded-3 @error('first_name') is-invalid @enderror" placeholder="នាមត្រកូល">
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">នាមខ្លួន <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control rounded-3 @error('last_name') is-invalid @enderror" placeholder="នាមខ្លួន">
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ថ្ងៃខែឆ្នាំកំណើត</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control rounded-3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ថ្នាក់</label>
                            <select name="class_id" class="form-select rounded-3">
                                <option value="">— ជ្រើសរើស —</option>
                                @foreach($classes as $class)<option value="{{ $class->id }}" {{ old('class_id')==$class->id?'selected':'' }}>{{ $class->class_name }}{{ $class->teacher?' ('.$class->teacher->name.')':'' }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">អ៊ីមែល</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control rounded-3 @error('email') is-invalid @enderror" placeholder="student@example.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ទូរស័ព្ទ</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control rounded-3" placeholder="012 345 678">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-500">អាសយដ្ឋាន</label>
                            <textarea name="address" rows="3" class="form-control rounded-3" placeholder="អាសយដ្ឋានរបស់សិស្ស...">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="camera" class="lucide-sm me-2"></i>រូបថត</h6></div>
                <div class="card-body p-4 text-center">
                    <div id="photoPreview" class="mb-3" style="width:120px;height:120px;border-radius:20px;background:#f1f5f9;margin:0 auto;overflow:hidden;border:2px dashed #cbd5e1;display:flex;align-items:center;justify-content:center;">
                        <i data-lucide="user" style="width:48px;height:48px;stroke:#94a3b8;"></i>
                    </div>
                    <label class="btn btn-outline-primary rounded-3 btn-sm" for="photoInput"><i data-lucide="upload" class="lucide-sm me-1"></i>ជ្រើសរូបថត</label>
                    <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*" onchange="previewPhoto(this)">
                    <div class="text-muted mt-2" style="font-size:.75rem;">JPG, PNG, WEBP — អតិបរមា 2MB</div>
                    @error('photo')<div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-accent rounded-3"><i data-lucide="check-circle" class="lucide-sm me-2"></i>រក្សាទុក</button>
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary rounded-3"><i data-lucide="x-circle" class="lucide-sm me-2"></i>បោះបង់</a>
            </div>
        </div>
    </div>
</form>
@endsection
@push('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { document.getElementById('photoPreview').innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
