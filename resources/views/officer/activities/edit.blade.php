<x-officer-app-layout>

    @section('content')
    <div class="container">
        <h1>Edit Activity</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('officer.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $activity->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $activity->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="datetime-local" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $activity->start_time->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="datetime-local" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $activity->end_time ? $activity->end_time->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $activity->location) }}">
            </div>

            <div class="mb-3">
                <label for="semester_id" class="form-label">Semester</label>
                <select name="semester_id" id="semester_id" class="form-control">
                    <option value="">Select Semester</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}" {{ old('semester_id', $activity->semester_id) == $semester->id ? 'selected' : '' }}>
                            {{ $semester->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="school_year" class="form-label">School Year</label>
                <input type="text" name="school_year" id="school_year" class="form-control" value="{{ old('school_year', $activity->school_year) }}">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control">
                @if($activity->image)
                    <img src="{{ Storage::url('images/' . $activity->image) }}" alt="Activity Image" style="width: 150px; margin-top: 10px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Activity</button>
            <a href="{{ route('officer.activities.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
    @endsection

    </x-officer-app-layout>
