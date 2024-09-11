<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Attendance Report</h1>
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>School ID</th>
                <th>Activity</th>
                <th>Semester</th>
                <th>School Year</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->user->name ?? 'N/A' }}</td>
                <td>{{ $attendance->user->school_id ?? 'N/A' }}</td>
                <td>{{ $attendance->activity->name ?? 'N/A' }}</td>
                <td>{{ $attendance->activity->semester->name ?? 'N/A' }}</td>
                <td>{{ $attendance->activity->school_year ?? 'N/A' }}</td>
                <td>{{ $attendance->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
