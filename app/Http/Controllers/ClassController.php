<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Http\Requests\StoreClassRequest;
use Illuminate\Http\Request;

// Controller សម្រាប់ CRUD ថ្នាក់រៀន
class ClassController extends Controller
{
    // បង្ហាញបញ្ជីថ្នាក់
    public function index(Request $request)
    {
        $search = $request->input('search');

        $classes = SchoolClass::with('teacher')
            ->withCount('students')
            ->when($search, function ($query, $search) {
                $query->where('class_name', 'like', "%{$search}%")
                      ->orWhere('room_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('classes.index', compact('classes', 'search'));
    }

    // បង្ហាញទំព័របន្ថែមថ្នាក់
    public function create()
    {
        // ទទួលបញ្ជីគ្រូ
        $teachers = Teacher::all();
        return view('classes.create', compact('teachers'));
    }

    // រក្សាទុកថ្នាក់ថ្មី
    public function store(StoreClassRequest $request)
    {
        SchoolClass::create($request->validated());
        return redirect()->route('classes.index')
            ->with('success', 'ថ្នាក់ត្រូវបានបន្ថែមដោយជោគជ័យ!');
    }

    // បង្ហាញព័ត៌មានលម្អិត
    public function show(SchoolClass $class)
    {
        $class->load('teacher', 'students');
        return view('classes.show', compact('class'));
    }

    // បង្ហាញទំព័រកែប្រែ
    public function edit(SchoolClass $class)
    {
        $teachers = Teacher::all();
        return view('classes.edit', compact('class', 'teachers'));
    }

    // រក្សាទុកការកែប្រែ
    public function update(StoreClassRequest $request, SchoolClass $class)
    {
        $class->update($request->validated());
        return redirect()->route('classes.index')
            ->with('success', 'ថ្នាក់ត្រូវបានកែប្រែដោយជោគជ័យ!!!');
    }

    // លុបថ្នាក់
    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')
            ->with('success', 'ថ្នាក់ត្រូវបានលុបដោយជោគជ័យ!');
    }
}
