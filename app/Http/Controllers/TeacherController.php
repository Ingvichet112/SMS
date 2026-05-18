<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use Illuminate\Http\Request;

// Controller សម្រាប់ CRUD គ្រូ
class TeacherController extends Controller
{
    // បង្ហាញបញ្ជីគ្រូ ជាមួយការស្វែងរក
    public function index(Request $request)
    {
        $search = $request->input('search');

        $teachers = Teacher::withCount('classes')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('teacher_id', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('subject', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('teachers.index', compact('teachers', 'search'));
    }

    // បង្ហាញទំព័របន្ថែមគ្រូ
    public function create()
    {
        return view('teachers.create');
    }

    // រក្សាទុកគ្រូថ្មី
    public function store(StoreTeacherRequest $request)
    {
        Teacher::create($request->validated());
        return redirect()->route('teachers.index')
            ->with('success', 'គ្រូត្រូវបានបន្ថែមដោយជោគជ័យ!');
    }

    // បង្ហាញព័ត៌មានលម្អិតរបស់គ្រូ
    public function show(Teacher $teacher)
    {
        $teacher->load('classes.students');
        return view('teachers.show', compact('teacher'));
    }

    // បង្ហាញទំព័រកែប្រែ
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    // រក្សាទុកការកែប្រែ
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->validated());
        return redirect()->route('teachers.index')
            ->with('success', 'ព័ត៌មានគ្រូត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    // លុបគ្រូ
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')
            ->with('success', 'គ្រូត្រូវបានលុបដោយជោគជ័យ!');
    }
}
