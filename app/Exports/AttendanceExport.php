<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithCustomStartCell
{
    protected $classId;
    protected $courseId;
    protected $date;
    protected $rowNumber = 0;

    public function __construct($classId, $courseId, $date)
    {
        $this->classId = $classId;
        $this->courseId = $courseId;
        $this->date = $date;
    }

    public function collection()
    {
        return Student::where('class_id', $this->classId)
            ->orderBy('first_name')
            ->get();
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function headings(): array
    {
        return [
            'No.',
            'Student ID',
            'Full Name',
            'Gender',
            'Status / ស្ថានភាព',
            'Remarks / សម្គាល់'
        ];
    }

    public function map($student): array
    {
        $this->rowNumber++;
        
        $attendance = Attendance::where('course_id', $this->courseId)
            ->where('attendance_date', $this->date)
            ->where('student_id', $student->id)
            ->first();

        $status = 'Not Marked';
        if ($attendance) {
            if ($attendance->status === 'present') {
                $status = 'Present / វត្តមាន';
            } elseif ($attendance->status === 'late') {
                $status = 'Late / យឺត';
            } elseif ($attendance->status === 'absent') {
                $status = 'Absent / អវត្តមាន';
            }
        }

        return [
            $this->rowNumber,
            $student->student_id,
            $student->first_name . ' ' . $student->last_name,
            $student->gender,
            $status,
            $attendance ? $attendance->remarks : ''
        ];
    }

    public function title(): string
    {
        return 'Attendance Sheet';
    }

    public function styles(Worksheet $sheet)
    {
        $activeClass = SchoolClass::find($this->classId);
        $activeCourse = Course::find($this->courseId);
        $className = $activeClass ? $activeClass->class_name : 'N/A';
        $courseName = $activeCourse ? $activeCourse->course_name : 'N/A';
        $formattedDate = date('D, M d, Y', strtotime($this->date));

        // Add metadata headers in the first 3 rows
        $sheet->setCellValue('A1', 'Student Attendance Sheet / បញ្ជីវត្តមានសិស្ស');
        $sheet->setCellValue('A2', "Class: {$className} | Subject: {$courseName} | Session Date: {$formattedDate}");
        
        // Merge cells for nice styling
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        // Style the title
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);
        
        // Return styles for the headings row (Row 4 since we start at A4)
        return [
            4 => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }
}
