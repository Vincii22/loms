<x-officer-app-layout>
    @section('content')
    <div class="container">
        <h1>Add Attendance Record</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('attendance.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700">Student</label>
                <select name="student_id" id="student_id" class="mt-1 block w-full">
                    @foreach($students as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('student_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="activity_id" class="form-label">Activity</label>
                <select name="activity_id" id="activity_id" class="form-control" required>
                    @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ request('activity') == $activity->id ? 'selected' : '' }}>{{ $activity->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="time_in" class="form-label">Time In</label>
                <input type="time" id="time_in" name="time_in" class="form-control" value="{{ old('time_in') }}" required>
            </div>

            <div class="mb-3">
                <label for="time_out" class="form-label">Time Out</label>
                <input type="time" id="time_out" name="time_out" class="form-control" value="{{ old('time_out') }}">
            </div>

            <button type="submit" class="btn btn-primary">Add Attendance</button>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
    @endsection
</x-officer-app-layout>
