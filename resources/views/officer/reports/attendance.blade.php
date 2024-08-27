<x-officer-app-layout>

@section('content')
<div class="container">
    <h1>Attendance Report</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Activity</th>
                <th>Date</th>
                <th>Student</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->id }}</td>
                <td>{{ $attendance->activity->name ?? 'N/A' }}</td> <!-- Handle missing activity -->
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->student->name ?? 'N/A' }}</td> <!-- Handle missing student -->
                <td>{{ $attendance->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
</x-officer-app-layout>
