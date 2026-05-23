@extends('layouts.app')
@section('title','កែប្រែសិស្ស')
@section('page-title','កែប្រែសិស្ស')
@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('students.show',$student) }}" class="btn btn-sm btn-outline-secondary rounded-3"><i data-lucide="arrow-left" class="lucide-sm"></i></a>
    <h5 class="fw-700 mb-0">កែប្រែ: {{ $student->full_name }}</h5>
</div>
<form method="POST" action="{{ route('students.update',$student) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="user" class="lucide-sm me-2"></i>ព័ត៌មានសិស្ស</h6></div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Student ID <span class="text-danger">*</span></label>
                            <input type="text" name="student_id" value="{{ old('student_id',$student->student_id) }}" class="form-control rounded-3 @error('student_id') is-invalid @enderror">
                            @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ភេទ <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select rounded-3 @error('gender') is-invalid @enderror">
                                @foreach(['Male','Female','Other'] as $g)<option value="{{ $g }}" {{ old('gender',$student->gender)==$g?'selected':'' }}>{{ $g }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">នាមត្រកូល <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name',$student->first_name) }}" class="form-control rounded-3 @error('first_name') is-invalid @enderror">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">នាមខ្លួន <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name',$student->last_name) }}" class="form-control rounded-3 @error('last_name') is-invalid @enderror">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ថ្ងៃខែឆ្នាំកំណើត</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth',$student->date_of_birth?->format('Y-m-d')) }}" class="form-control rounded-3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ថ្នាក់</label>
                            <select name="class_id" class="form-select rounded-3">
                                <option value="">— ជ្រើសរើស —</option>
                                @foreach($classes as $class)<option value="{{ $class->id }}" {{ old('class_id',$student->class_id)==$class->id?'selected':'' }}>{{ $class->class_name }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">អ៊ីមែល</label>
                            <input type="email" name="email" value="{{ old('email',$student->email) }}" class="form-control rounded-3 @error('email') is-invalid @enderror">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ពាក្យសម្ងាត់ (ទុកទំនេរ ប្រសិនបើមិនផ្លាស់ប្ដូរ)</label>
                            <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" placeholder="••••••••">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ទូរស័ព្ទ</label>
                            <input type="text" name="phone" value="{{ old('phone',$student->phone) }}" class="form-control rounded-3">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-500">អាសយដ្ឋាន</label>
                            <textarea name="address" rows="3" class="form-control rounded-3">{{ old('address',$student->address) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="camera" class="lucide-sm me-2"></i>រូបថត</h6></div>
                <div class="card-body p-4 text-center">
                    <div id="photoPreview" class="mb-3" style="width:120px;height:120px;border-radius:20px;overflow:hidden;border:2px dashed #cbd5e1;margin:0 auto;">
                        <img src="{{ $student->photo_url }}" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <label class="btn btn-outline-primary rounded-3 btn-sm" for="photoInput"><i data-lucide="upload" class="lucide-sm me-1"></i>ផ្លាស់ប្ដូររូបថត</label>
                    <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*" onchange="previewPhoto(this)">
                </div>
            </div>
            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-accent rounded-3"><i data-lucide="check-circle" class="lucide-sm me-2"></i>រក្សាទុក</button>
                <a href="{{ route('students.show',$student) }}" class="btn btn-outline-secondary rounded-3">បោះបង់</a>
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
