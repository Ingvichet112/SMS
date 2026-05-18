@extends('layouts.app')
@section('title','បន្ថែមថ្នាក់')
@section('page-title','បន្ថែមថ្នាក់')
@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('classes.index') }}" class="btn btn-sm btn-outline-secondary rounded-3"><i data-lucide="arrow-left" class="lucide-sm"></i></a>
    <h5 class="fw-700 mb-0">បន្ថែមថ្នាក់ថ្មី</h5>
</div>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="building-2" class="lucide-sm me-2"></i>ព័ត៌មានថ្នាក់</h6></div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('classes.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-500">ឈ្មោះថ្នាក់ <span class="text-danger">*</span></label>
                            <input type="text" name="class_name" value="{{ old('class_name') }}" class="form-control rounded-3 @error('class_name') is-invalid @enderror" placeholder="ឧ. ថ្នាក់ទី ១២ A">
                            @error('class_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-500">លេខបន្ទប់</label>
                            <input type="text" name="room_number" value="{{ old('room_number') }}" class="form-control rounded-3" placeholder="ឧ. 101, A2">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-500">គ្រូ (ប្រចាំថ្នាក់)</label>
                            <select name="teacher_id" class="form-select rounded-3">
                                <option value="">— ជ្រើសរើស —</option>
                                @foreach($teachers as $teacher)<option value="{{ $teacher->id }}" {{ old('teacher_id')==$teacher->id?'selected':'' }}>{{ $teacher->name }} — {{ $teacher->subject }}</option>@endforeach
                            </select>
                        </div>
                        <div class="col-12 d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-accent rounded-3 px-4"><i data-lucide="check-circle" class="lucide-sm me-2"></i>រក្សាទុក</button>
                            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary rounded-3 px-4">បោះបង់</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
