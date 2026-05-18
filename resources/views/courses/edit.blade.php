@extends('layouts.app')
@section('title','កែប្រែមុខវិជ្ជា')
@section('page-title','កែប្រែមុខវិជ្ជា')
@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-secondary rounded-3"><i data-lucide="arrow-left" class="lucide-sm"></i></a>
    <h5 class="fw-700 mb-0">កែប្រែ: {{ $course->course_name }}</h5>
</div>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3 px-4"><h6 class="mb-0 fw-600"><i data-lucide="book-open" class="lucide-sm me-2"></i>ព័ត៌មានមុខវិជ្ជា</h6></div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('courses.update',$course) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">លេខកូដ <span class="text-danger">*</span></label>
                            <input type="text" name="course_code" value="{{ old('course_code',$course->course_code) }}" class="form-control rounded-3 @error('course_code') is-invalid @enderror">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">ចំនួនក្រេឌីត</label>
                            <input type="number" name="credit" value="{{ old('credit',$course->credit) }}" min="1" max="10" class="form-control rounded-3">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-500">ឈ្មោះមុខវិជ្ជា <span class="text-danger">*</span></label>
                            <input type="text" name="course_name" value="{{ old('course_name',$course->course_name) }}" class="form-control rounded-3 @error('course_name') is-invalid @enderror">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-500">ការពិពណ៌នា</label>
                            <textarea name="description" rows="4" class="form-control rounded-3">{{ old('description',$course->description) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2 pt-2">
                            <button type="submit" class="btn btn-accent rounded-3 px-4"><i data-lucide="check-circle" class="lucide-sm me-2"></i>រក្សាទុក</button>
                            <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary rounded-3 px-4">បោះបង់</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
