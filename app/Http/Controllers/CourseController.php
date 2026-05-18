<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\Request;

// Controller សម្រាប់ CRUD មុខវិជ្ជា
class CourseController extends Controller
{
    // បង្ហាញបញ្ជីមុខវិជ្ជា
    public function index(Request $request)
    {
        $search = $request->input('search');

        $courses = Course::when($search, function ($query, $search) {
                $query->where('course_name', 'like', "%{$search}%")
                      ->orWhere('course_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('courses.index', compact('courses', 'search'));
    }

    // បង្ហាញទំព័របន្ថែមមុខវិជ្ជា
    public function create()
    {
        return view('courses.create');
    }

    // រក្សាទុកមុខវិជ្ជាថ្មី
    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated());
        return redirect()->route('courses.index')
            ->with('success', 'មុខវិជ្ជាត្រូវបានបន្ថែមដោយជោគជ័យ!');
    }

    // បង្ហាញទំព័រកែប្រែ
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // រក្សាទុកការកែប្រែ
    public function update(StoreCourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        return redirect()->route('courses.index')
            ->with('success', 'មុខវិជ្ជាត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    // លុបមុខវិជ្ជា
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')
            ->with('success', 'មុខវិជ្ជាត្រូវបានលុបដោយជោគជ័យ!');
    }
}
