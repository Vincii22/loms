<!-- resources/views/student/attendance/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Attendance Details</h1>

        <div class="card">
            <div class="card-header">
                Attendance for Activity: {{ $attendance->activity->name }}
            </div>
            <div class="card-body">
                <p><strong>Activity Name:</strong> {{ $attendance->activity->name }}</p>
                <p><strong>Time In:</strong> {{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i') : 'N/A' }}</p>
                <p><strong>Time Out:</strong> {{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i') : 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $attendance->status }}</p>
                <a href="{{ route('sAttendance.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
