<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\ExamSchedule;
use App\Models\Mark;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    // Retrieve the teacher profile of the currently logged in teacher user
    private function getTeacher()
    {
        $user = Auth::user();
        if (!$user) return null;
        return $user->teacher;
    }

    public function index()
    {
        $teacher = $this->getTeacher();
        if (!$teacher) {
            return redirect('/login')->withErrors(['email' => 'គណនីនេះមិនទាន់មានព័ត៌មានគ្រូនៅឡើយទេ។']);
        }

        // Classes taught by this teacher (where they are the class teacher)
        $classes = $teacher->classes()->with('students')->get();
        $classIds = $classes->pluck('id')->toArray();

        // Total students in their classes
        $totalStudents = $classes->sum(function($class) {
            return $class->students->count();
        });

        // Subjects available
        $teacherSubjects = array_map('trim', explode(',', $teacher->subject ?? ''));
        $subjectsCount = Course::where(function($query) use ($teacherSubjects) {
            foreach ($teacherSubjects as $sub) {
                if (!empty($sub)) {
                    $query->orWhere('course_name', 'like', "%{$sub}%");
                }
            }
        })->count();
        if ($subjectsCount === 0) {
            $subjectsCount = Course::count();
        }

        // Upcoming exams in their classes
        $upcomingExams = ExamSchedule::with(['course', 'schoolClass'])
            ->whereIn('class_id', $classIds)
            ->where('exam_date', '>=', now()->toDateString())
            ->orderBy('exam_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        // Recent attendance counts (today)
        $todayAttendanceCount = Attendance::where('attendance_date', now()->toDateString())
            ->whereIn('student_id', function($query) use ($classIds) {
                $query->select('id')->from('students')->whereIn('class_id', $classIds);
            })->count();

        return view('teacher.dashboard', compact('teacher', 'classes', 'totalStudents', 'subjectsCount', 'upcomingExams', 'todayAttendanceCount'));
    }

    public function attendance(Request $request)
    {
        $teacher = $this->getTeacher();
        if (!$teacher) return redirect('/login');

        $classes = $teacher->classes; // Dynamically get classes taught by this teacher
        
        // Dynamically get only the courses/subjects taught by this teacher
        $teacherSubjects = array_map('trim', explode(',', $teacher->subject ?? ''));
        $courses = Course::where(function($query) use ($teacherSubjects) {
            foreach ($teacherSubjects as $sub) {
                if (!empty($sub)) {
                    $query->orWhere('course_name', 'like', "%{$sub}%");
                }
            }
        })->get();
        if ($courses->isEmpty()) {
            $courses = Course::all();
        }

        // Get the selected week's Monday (or current week's Monday as default)
        $selectedWeekStart = $request->input('week_start');
        if (!$selectedWeekStart) {
            $selectedWeekStart = \Carbon\Carbon::now()->startOfWeek()->toDateString();
        } else {
            $selectedWeekStart = \Carbon\Carbon::parse($selectedWeekStart)->startOfWeek()->toDateString();
        }

        $monday = \Carbon\Carbon::parse($selectedWeekStart);
        $tuesday = $monday->copy()->addDay();
        $wednesday = $monday->copy()->addDays(2);
        $thursday = $monday->copy()->addDays(3);
        $friday = $monday->copy()->addDays(4);

        $weekDates = [
            'Monday' => $monday->toDateString(),
            'Tuesday' => $tuesday->toDateString(),
            'Wednesday' => $wednesday->toDateString(),
            'Thursday' => $thursday->toDateString(),
            'Friday' => $friday->toDateString(),
        ];

        // Define time slots for the dynamic schedule
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [
            ['start' => '08:00', 'end' => '09:30', 'label' => '08:00 AM - 09:30 AM'],
            ['start' => '10:00', 'end' => '11:30', 'label' => '10:00 AM - 11:30 AM'],
            ['start' => '13:30', 'end' => '15:00', 'label' => '01:30 PM - 03:00 PM'],
            ['start' => '15:30', 'end' => '17:00', 'label' => '03:30 PM - 05:00 PM'],
        ];

        $schedule = [];
        foreach ($days as $dayIndex => $day) {
            $schedule[$day] = [];
            $date = $weekDates[$day];
            
            // We schedule up to 2 classes per day
            for ($slotIndex = 0; $slotIndex < 2; $slotIndex++) {
                if ($classes->isEmpty()) continue;
                
                $classIndex = ($dayIndex * 2 + $slotIndex) % $classes->count();
                $class = $classes->values()->get($classIndex);
                
                if ($courses->isEmpty()) continue;
                $courseIndex = ($dayIndex + $slotIndex) % $courses->count();
                $course = $courses->values()->get($courseIndex);
                
                $timeSlot = $timeSlots[($dayIndex + $slotIndex) % count($timeSlots)];
                
                // Fetch attendance status to calculate checked progress on this card
                $studentIds = $class->students->pluck('id')->toArray();
                $checkedAttendance = Attendance::where('course_id', $course->id)
                    ->where('attendance_date', $date)
                    ->whereIn('student_id', $studentIds)
                    ->get();
                
                $totalStudentsCount = count($studentIds);
                $isChecked = $checkedAttendance->isNotEmpty();
                $presentCount = $checkedAttendance->where('status', 'present')->count();
                $lateCount = $checkedAttendance->where('status', 'late')->count();
                $absentCount = $checkedAttendance->where('status', 'absent')->count();
                
                $schedule[$day][] = [
                    'class_id' => $class->id,
                    'class_name' => $class->class_name,
                    'room_number' => $class->room_number,
                    'course_id' => $course->id,
                    'course_name' => $course->course_name,
                    'start_time' => $timeSlot['start'],
                    'end_time' => $timeSlot['end'],
                    'time_label' => $timeSlot['label'],
                    'date' => $date,
                    'is_checked' => $isChecked,
                    'total_students' => $totalStudentsCount,
                    'present_count' => $presentCount,
                    'late_count' => $lateCount,
                    'absent_count' => $absentCount,
                ];
            }
        }

        $selectedClassId = $request->input('class_id');
        $selectedCourseId = $request->input('course_id');
        $selectedDate = $request->input('attendance_date');

        // Auto-select class session if not actively requested
        if (!$selectedClassId || !$selectedCourseId || !$selectedDate) {
            $todayDate = now()->toDateString();
            $autoSelected = false;
            foreach ($schedule as $day => $slots) {
                foreach ($slots as $slot) {
                    if ($slot['date'] === $todayDate) {
                        $selectedClassId = $slot['class_id'];
                        $selectedCourseId = $slot['course_id'];
                        $selectedDate = $slot['date'];
                        $autoSelected = true;
                        break 2;
                    }
                }
            }
            if (!$autoSelected) {
                foreach ($schedule as $day => $slots) {
                    if (!empty($slots)) {
                        $selectedClassId = $slots[0]['class_id'];
                        $selectedCourseId = $slots[0]['course_id'];
                        $selectedDate = $slots[0]['date'];
                        break;
                    }
                }
            }
        }

        $students = collect();
        $existingAttendances = collect();
        $activeClass = null;
        $activeCourse = null;

        if ($selectedClassId && $selectedCourseId && $selectedDate) {
            $students = Student::where('class_id', $selectedClassId)->orderBy('first_name')->get();
            $existingAttendances = Attendance::where('course_id', $selectedCourseId)
                ->where('attendance_date', $selectedDate)
                ->whereIn('student_id', $students->pluck('id'))
                ->get()
                ->keyBy('student_id');
            
            $activeClass = SchoolClass::find($selectedClassId);
            $activeCourse = Course::find($selectedCourseId);
        }

        return view('teacher.attendance', compact(
            'teacher',
            'classes',
            'courses',
            'students',
            'existingAttendances',
            'selectedClassId',
            'selectedCourseId',
            'selectedDate',
            'selectedWeekStart',
            'weekDates',
            'schedule',
            'activeClass',
            'activeCourse'
        ));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late',
            'remarks' => 'nullable|array',
        ]);

        $courseId = $request->input('course_id');
        $date = $request->input('attendance_date');
        $attendanceData = $request->input('attendance');
        $remarksData = $request->input('remarks', []);

        foreach ($attendanceData as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_id' => $courseId,
                    'attendance_date' => $date,
                ],
                [
                    'status' => $status,
                    'remarks' => $remarksData[$studentId] ?? null,
                ]
            );
        }

        $weekStart = \Carbon\Carbon::parse($date)->startOfWeek()->toDateString();

        return redirect()->route('teacher.attendance', [
            'class_id' => $request->input('class_id'),
            'course_id' => $courseId,
            'attendance_date' => $date,
            'week_start' => $weekStart
        ])->with('success', 'កត់ត្រាវត្តមានសិស្សដោយជោគជ័យ!');
    }

    public function exportAttendance(Request $request)
    {
        $teacher = $this->getTeacher();
        if (!$teacher) return redirect('/login');

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'course_id' => 'required|exists:courses,id',
            'attendance_date' => 'required|date',
        ]);

        $classId = $request->input('class_id');
        $courseId = $request->input('course_id');
        $date = $request->input('attendance_date');

        $activeClass = \App\Models\SchoolClass::find($classId);
        $activeCourse = \App\Models\Course::find($courseId);
        
        $className = $activeClass ? $activeClass->class_name : 'class';
        $courseName = $activeCourse ? $activeCourse->course_name : 'subject';
        $fileName = "attendance_{$className}_{$courseName}_{$date}.xlsx";
        
        // Remove spaces or weird characters from filename
        $fileName = str_replace([' ', '/', '\\'], '_', $fileName);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AttendanceExport($classId, $courseId, $date), 
            $fileName
        );
    }

    public function scores(Request $request)
    {
        $teacher = $this->getTeacher();
        if (!$teacher) return redirect('/login');

        $classes = $teacher->classes; // Dynamically get classes taught by this teacher
        
        // Dynamically get only the courses/subjects taught by this teacher
        $teacherSubjects = array_map('trim', explode(',', $teacher->subject ?? ''));
        $courses = Course::where(function($query) use ($teacherSubjects) {
            foreach ($teacherSubjects as $sub) {
                if (!empty($sub)) {
                    $query->orWhere('course_name', 'like', "%{$sub}%");
                }
            }
        })->get();
        if ($courses->isEmpty()) {
            $courses = Course::all();
        }

        $firstClass = $classes->first();
        $selectedClassId = $request->input('class_id', $firstClass ? $firstClass->id : null);
        $selectedCourseId = $request->input('course_id');
        $selectedSemester = $request->input('semester', 'Semester 1');
        $selectedAcademicYear = $request->input('academic_year', '2023-2024');

        $students = collect();
        $existingMarks = collect();

        if ($selectedClassId && $selectedCourseId) {
            $students = Student::where('class_id', $selectedClassId)->orderBy('first_name')->get();
            $existingMarks = Mark::where('course_id', $selectedCourseId)
                ->where('semester', $selectedSemester)
                ->where('academic_year', $selectedAcademicYear)
                ->whereIn('student_id', $students->pluck('id'))
                ->get()
                ->keyBy('student_id');
        }

        return view('teacher.scores', compact(
            'teacher',
            'classes',
            'courses',
            'students',
            'existingMarks',
            'selectedClassId',
            'selectedCourseId',
            'selectedSemester',
            'selectedAcademicYear'
        ));
    }

    public function storeScores(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $courseId = $request->input('course_id');
        $semester = $request->input('semester');
        $academicYear = $request->input('academic_year');
        $scoresData = $request->input('scores');

        foreach ($scoresData as $studentId => $score) {
            if ($score === null || $score === '') {
                // If score is cleared, delete the mark record if it exists
                Mark::where([
                    'student_id' => $studentId,
                    'course_id' => $courseId,
                    'semester' => $semester,
                    'academic_year' => $academicYear,
                ])->delete();
            } else {
                Mark::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'course_id' => $courseId,
                        'semester' => $semester,
                        'academic_year' => $academicYear,
                    ],
                    [
                        'score' => $score,
                    ]
                );
            }
        }

        return redirect()->route('teacher.scores', [
            'class_id' => $request->input('class_id'),
            'course_id' => $courseId,
            'semester' => $semester,
            'academic_year' => $academicYear
        ])->with('success', 'រក្សាទុកពិន្ទុសិស្សដោយជោគជ័យ!');
    }

    public function exams(Request $request)
    {
        $teacher = $this->getTeacher();
        if (!$teacher) return redirect('/login');

        $classes = $teacher->classes; // Dynamically get classes taught by this teacher
        
        // Dynamically get only the courses/subjects taught by this teacher
        $teacherSubjects = array_map('trim', explode(',', $teacher->subject ?? ''));
        $courses = Course::where(function($query) use ($teacherSubjects) {
            foreach ($teacherSubjects as $sub) {
                if (!empty($sub)) {
                    $query->orWhere('course_name', 'like', "%{$sub}%");
                }
            }
        })->get();
        if ($courses->isEmpty()) {
            $courses = Course::all();
        }

        $firstClass = $classes->first();
        $selectedClassId = $request->input('class_id', $firstClass ? $firstClass->id : null);
        
        $exams = ExamSchedule::with(['course', 'schoolClass'])
            ->when($selectedClassId, function($query) use ($selectedClassId) {
                $query->where('class_id', $selectedClassId);
            })
            ->orderBy('exam_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('teacher.exams', compact('teacher', 'classes', 'courses', 'exams', 'selectedClassId'));
    }

    public function storeExams(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'course_id' => 'required|exists:courses,id',
            'exam_name' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'nullable|string|max:255',
        ]);

        ExamSchedule::create($request->all());

        return redirect()->route('teacher.exams', ['class_id' => $request->input('class_id')])
            ->with('success', 'បង្កើតការកាលបរិច្ឆេទប្រឡងដោយជោគជ័យ!');
    }

    public function destroyExam(ExamSchedule $exam)
    {
        $classId = $exam->class_id;
        $exam->delete();
        return redirect()->route('teacher.exams', ['class_id' => $classId])
            ->with('success', 'លុបការកាលបរិច្ឆេទប្រឡងដោយជោគជ័យ!');
    }
}
