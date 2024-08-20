<x-officer-app-layout>

@section('content')
<div class="container">
    <h1>Edit Attendance Record</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="student_id" class="form-label">Student</label>
            <select name="student_id" id="student_id" class="form-control">
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ $attendance->student_id == $student->id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="activity_id" class="form-label">Activity</label>
            <select name="activity_id" id="activity_id" class="form-control">
                @foreach($activities as $activity)
                    <option value="{{ $activity->id }}" {{ $attendance->activity_id == $activity->id ? 'selected' : '' }}>
                        {{ $activity->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="time_in" class="form-label">Time In</label>
            <input type="time" name="time_in" id="time_in" class="form-control" value="{{ $attendance->time_in }}" required>
        </div>

        <div class="mb-3">
            <label for="time_out" class="form-label">Time Out</label>
            <input type="time" name="time_out" id="time_out" class="form-control" value="{{ $attendance->time_out }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Attendance</button>
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
</x-officer-app-layout>
