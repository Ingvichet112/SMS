<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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
        $courses = \App\Models\Course::orderBy('course_name')->get();
        return view('teachers.create', compact('courses'));
    }

    // រក្សាទុកគ្រូថ្មី
    public function store(StoreTeacherRequest $request)
    {
        $data = $request->validated();
        if (isset($data['subjects'])) {
            $data['subject'] = implode(', ', $data['subjects']);
            unset($data['subjects']);
        }

        // ដំណើរការរូបថតគ្រូ
        if ($request->hasFile('photo')) {
            $uploadDir = public_path('uploads/teachers');
            File::ensureDirectoryExists($uploadDir);
            $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move($uploadDir, $filename);
            $data['photo'] = 'uploads/teachers/' . $filename;
        }

        // បង្កើត User account ប្រសិនបើមានអ៊ីមែល
        if (!empty($data['email'])) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password'] ?? 'password123'), // Default password if empty
                'role'     => 'teacher',
            ]);
            $data['user_id'] = $user->id;
        }

        Teacher::create($data);
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
        $courses = \App\Models\Course::orderBy('course_name')->get();
        return view('teachers.edit', compact('teacher', 'courses'));
    }

    // រក្សាទុកការកែប្រែ
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $data = $request->validated();
        if (isset($data['subjects'])) {
            $data['subject'] = implode(', ', $data['subjects']);
            unset($data['subjects']);
        }

        // ដំណើរការរូបថតថ្មី
        if ($request->hasFile('photo')) {
            // លុបរូបចាស់
            if ($teacher->photo && file_exists(public_path($teacher->photo))) {
                File::delete(public_path($teacher->photo));
            }
            $uploadDir = public_path('uploads/teachers');
            File::ensureDirectoryExists($uploadDir);
            $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move($uploadDir, $filename);
            $data['photo'] = 'uploads/teachers/' . $filename;
        }

        // ធ្វើបច្ចុប្បន្នភាព ឬបង្កើត User account
        if (!empty($data['email'])) {
            if ($teacher->user) {
                // Update existing user
                $updateData = [
                    'name'  => $data['name'],
                    'email' => $data['email'],
                ];
                if (!empty($data['password'])) {
                    $updateData['password'] = Hash::make($data['password']);
                }
                $teacher->user->update($updateData);
            } else {
                // Create new user if not exists
                $user = User::create([
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'password' => Hash::make($data['password'] ?? 'password123'),
                    'role'     => 'teacher',
                ]);
                $data['user_id'] = $user->id;
            }
        }

        $teacher->update($data);
        return redirect()->route('teachers.index')
            ->with('success', 'ព័ត៌មានគ្រូត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    // លុបគ្រូ
    public function destroy(Teacher $teacher)
    {
        // លុបរូបថតផងដែរ
        if ($teacher->photo && file_exists(public_path($teacher->photo))) {
            File::delete(public_path($teacher->photo));
        }
        $teacher->delete();
        return redirect()->route('teachers.index')
            ->with('success', 'គ្រូត្រូវបានលុបដោយជោគជ័យ!');
    }
}
