@extends('layouts.app')
@section('title','បន្ថែមគ្រូ')
@section('page-title','បន្ថែមគ្រូ')
@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-outline-secondary rounded-3"><i data-lucide="arrow-left" class="lucide-sm"></i></a>
    <h5 class="fw-700 mb-0">បន្ថែមគ្រូថ្មី</h5>
</div>
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="user-cog" class="lucide-sm me-2"></i>ព័ត៌មានគ្រូ</h6></div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('teachers.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Teacher ID <span class="text-danger">*</span></label>
                            <input type="text" name="teacher_id" value="{{ old('teacher_id') }}" class="form-control rounded-3 @error('teacher_id') is-invalid @enderror" placeholder="TCH-001">
                            @error('teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ឈ្មោះ <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded-3 @error('name') is-invalid @enderror" placeholder="ឈ្មោះគ្រូ">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                            <label class="form-label fw-500">មុខវិជ្ជា <span class="text-danger">*</span></label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="form-control rounded-3 @error('subject') is-invalid @enderror" placeholder="ឧ. គណិតវិទ្យា">
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">អ៊ីមែល <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control rounded-3 @error('email') is-invalid @enderror" placeholder="teacher@school.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ទូរស័ព្ទ</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control rounded-3" placeholder="012 345 678">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-500">អាសយដ្ឋាន</label>
                            <textarea name="address" rows="3" class="form-control rounded-3">{{ old('address') }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-accent rounded-3 px-4"><i data-lucide="check-circle" class="lucide-sm me-2"></i>រក្សាទុក</button>
                            <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary rounded-3 px-4">បោះបង់</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
