<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Exports\StudentsExport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

// Controller សម្រាប់ CRUD សិស្ស
class StudentController extends Controller
{
    // បង្ហាញបញ្ជីសិស្ស ជាមួយការស្វែងរក និង Pagination
    public function index(Request $request)
    {
        // ទទួល keyword ស្វែងរក
        $search = $request->input('search');

        $students = Student::with('schoolClass')
            ->when($search, function ($query, $search) {
                // ស្វែងរកតាម ឈ្មោះ, Student ID, ឬ Email
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students', 'search'));
    }

    // បង្ហាញទំព័របន្ថែមសិស្ស
    public function create()
    {
        // ទទួលបញ្ជីថ្នាក់ទាំងអស់
        $classes = SchoolClass::with('teacher')->get();
        return view('students.create', compact('classes'));
    }

    // រក្សាទុកសិស្សថ្មី
    public function store(StoreStudentRequest $request)
    {
        // Validate ទិន្នន័យ (ធ្វើដោយ StoreStudentRequest)
        $data = $request->validated();

        // ដំណើរការរូបថត — រក្សាទុកក្នុង public/uploads/students/
        if ($request->hasFile('photo')) {
            $uploadDir = public_path('uploads/students');
            File::ensureDirectoryExists($uploadDir);
            $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move($uploadDir, $filename);
            $data['photo'] = 'uploads/students/' . $filename;
        }

        // បង្កើត User account ប្រសិនបើមានអ៊ីមែល
        if (!empty($data['email'])) {
            $user = User::create([
                'name'     => $data['first_name'] . ' ' . $data['last_name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password'] ?? 'password123'), // Default password if empty
                'role'     => 'student',
            ]);
            $data['user_id'] = $user->id;
        }

        // បង្កើតសិស្សថ្មី
        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'សិស្សត្រូវបានបន្ថែមដោយជោគជ័យ!');
    }

    // បង្ហាញព័ត៌មានលម្អិតរបស់សិស្ស
    public function show(Student $student)
    {
        $student->load('schoolClass.teacher');
        return view('students.show', compact('student'));
    }

    // បង្ហាញទំព័រកែប្រែសិស្ស
    public function edit(Student $student)
    {
        $classes = SchoolClass::with('teacher')->get();
        return view('students.edit', compact('student', 'classes'));
    }

    // រក្សាទុកការកែប្រែ
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $data = $request->validated();

        // ដំណើរការរូបថតថ្មី
        if ($request->hasFile('photo')) {
            // លុបរូបចាស់
            if ($student->photo && file_exists(public_path($student->photo))) {
                File::delete(public_path($student->photo));
            }
            $uploadDir = public_path('uploads/students');
            File::ensureDirectoryExists($uploadDir);
            $filename = time() . '_' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move($uploadDir, $filename);
            $data['photo'] = 'uploads/students/' . $filename;
        }

        // ធ្វើបច្ចុប្បន្នភាព ឬបង្កើត User account
        if (!empty($data['email'])) {
            if ($student->user) {
                // Update existing user
                $updateData = [
                    'name'  => $data['first_name'] . ' ' . $data['last_name'],
                    'email' => $data['email'],
                ];
                if (!empty($data['password'])) {
                    $updateData['password'] = Hash::make($data['password']);
                }
                $student->user->update($updateData);
            } else {
                // Create new user if not exists
                $user = User::create([
                    'name'     => $data['first_name'] . ' ' . $data['last_name'],
                    'email'    => $data['email'],
                    'password' => Hash::make($data['password'] ?? 'password123'),
                    'role'     => 'student',
                ]);
                $data['user_id'] = $user->id;
            }
        }

        // កែប្រែទិន្នន័យ
        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'ព័ត៌មានសិស្សត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    // លុបសិស្ស
    public function destroy(Student $student)
    {
        // លុបរូបថតផងដែរ
        if ($student->photo && file_exists(public_path($student->photo))) {
            File::delete(public_path($student->photo));
        }
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'សិស្សត្រូវបានលុបដោយជោគជ័យ!');
    }

    // Export PDF (using mPDF for Khmer font support)
    public function exportPdf(Request $request)
    {
        $search = $request->input('search');
        $students = Student::with('schoolClass')
            ->when($search, fn($q) => $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%"))
            ->latest()->get();

        // Render the blade view to HTML
        $html = view('students.pdf', compact('students'))->render();

        // Create mPDF instance with Khmer font support
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L', // Landscape
            'default_font_size' => 11,
            'default_font' => 'notosanskh',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'tempDir' => storage_path('fonts/ttfontdata'),
            'fontDir' => array_merge(
                (new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'],
                [storage_path('fonts')]
            ),
            'fontdata' => array_merge(
                (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'],
                [
                    'notosanskh' => [
                        'R' => 'NotoSansKhmer-Regular.ttf',
                        'B' => 'NotoSansKhmer-Bold.ttf',
                    ],
                ]
            ),
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('students-list.pdf', \Mpdf\Output\Destination::STRING_RETURN), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="students-list.pdf"',
        ]);
    }

    // Export Excel
    public function exportExcel()
    {
        // Export ទៅ Excel
        return Excel::download(new StudentsExport, 'students-list.xlsx');
    }
}
