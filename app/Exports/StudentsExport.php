<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Export សិស្សទៅ Excel
class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    // ទទួលទិន្នន័យសិស្សទាំងអស់
    public function collection()
    {
        return Student::with('schoolClass')->latest()->get();
    }

    // ស្ទើ Excel headers
    public function headings(): array
    {
        return [
            'Student ID',
            'First Name',
            'Last Name',
            'Gender',
            'Date of Birth',
            'Email',
            'Phone',
            'Class',
            'Address',
            'Created At',
        ];
    }

    // Map ទិន្នន័យ
    public function map($student): array
    {
        return [
            $student->student_id,
            $student->first_name,
            $student->last_name,
            $student->gender,
            $student->date_of_birth?->format('Y-m-d'),
            $student->email,
            $student->phone,
            $student->schoolClass?->class_name ?? 'N/A',
            $student->address,
            $student->created_at->format('Y-m-d'),
        ];
    }

    // ស្ទីល Row ស្ទើ
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
