<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <title>Students List</title>
    <style>
        body {
            font-family: 'notosanskh', sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
        }
        .header {
            background: #6366f1;
            color: #fff;
            padding: 16px 20px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        .header h1 { margin: 0; font-size: 18px; }
        .header p  { margin: 4px 0 0; font-size: 11px; opacity: .8; }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f1f5f9;
            color: #475569;
            font-size: 9px;
            padding: 8px 10px;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        tr:nth-child(even) td { background: #fafafa; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
        }
        .male   { background: #dbeafe; color: #1d4ed8; }
        .female { background: #fce7f3; color: #be185d; }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Student Management System</h1>
        <p>បញ្ជីសិស្ស — Generated: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student ID</th>
                <th>ឈ្មោះ</th>
                <th>ភេទ (Sex)</th>
                <th>ថ្ងៃកំណើត</th>
                <th>Email</th>
                <th>ទូរស័ព្ទ</th>
                <th>អាសយដ្ឋាន</th>
                <th>ថ្នាក់ (Class)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $i => $s)
            <tr>
                <td>{{ $i+1 }}</td>
                <td><strong>{{ $s->student_id }}</strong></td>
                <td>{{ $s->full_name }}</td>
                <td>
                    <span class="badge {{ strtolower($s->gender) }}">{{ $s->gender }}</span>
                </td>
                <td>{{ $s->date_of_birth?->format('d/m/Y') ?? '—' }}</td>
                <td>{{ $s->email ?? '—' }}</td>
                <td>{{ $s->phone ?? '—' }}</td>
                <td>{{ $s->address ?? '—' }}</td>
                <td>{{ $s->schoolClass?->class_name ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total: {{ $students->count() }} students — Student Management System © {{ date('Y') }}
    </div>
</body>
</html>
