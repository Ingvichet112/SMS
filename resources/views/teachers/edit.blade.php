@extends('layouts.app')
@section('title','កែប្រែគ្រូ')
@section('page-title','កែប្រែគ្រូ')
@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-outline-secondary rounded-3"><i data-lucide="arrow-left" class="lucide-sm"></i></a>
    <h5 class="fw-700 mb-0">កែប្រែ: {{ $teacher->name }}</h5>
</div>
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="user-cog" class="lucide-sm me-2"></i>ព័ត៌មានគ្រូ</h6></div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('teachers.update',$teacher) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Teacher ID <span class="text-danger">*</span></label>
                            <input type="text" name="teacher_id" value="{{ old('teacher_id',$teacher->teacher_id) }}" class="form-control rounded-3 @error('teacher_id') is-invalid @enderror">
                            @error('teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ឈ្មោះ <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name',$teacher->name) }}" class="form-control rounded-3 @error('name') is-invalid @enderror">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ភេទ <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select rounded-3">
                                @foreach(['Male','Female','Other'] as $g)<option value="{{ $g }}" {{ old('gender',$teacher->gender)==$g?'selected':'' }}>{{ $g }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">មុខវិជ្ជា <span class="text-danger">*</span></label>
                            <input type="text" name="subject" value="{{ old('subject',$teacher->subject) }}" class="form-control rounded-3 @error('subject') is-invalid @enderror">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">អ៊ីមែល <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email',$teacher->email) }}" class="form-control rounded-3 @error('email') is-invalid @enderror">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ទូរស័ព្ទ</label>
                            <input type="text" name="phone" value="{{ old('phone',$teacher->phone) }}" class="form-control rounded-3">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-500">អាសយដ្ឋាន</label>
                            <textarea name="address" rows="3" class="form-control rounded-3">{{ old('address',$teacher->address) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-accent rounded-3 px-4"><i data-lucide="check-circle" class="lucide-sm me-2"></i>រក្សាទុក</button>
                            <a href="{{ route('teachers.show',$teacher) }}" class="btn btn-outline-secondary rounded-3 px-4">បោះបង់</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
