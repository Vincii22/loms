<x-officer-app-layout>

    @section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Create New Activity</h1>

        <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea id="description" name="description" class="form-textarea mt-1 block w-full"></textarea>
            </div>
            <div class="mb-4">
                <label for="start_time" class="block text-gray-700">Start Time</label>
                <input type="datetime-local" id="start_time" name="start_time" class="form-input mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="end_time" class="block text-gray-700">End Time</label>
                <input type="datetime-local" id="end_time" name="end_time" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="location" class="block text-gray-700">Location</label>
                <input type="text" id="location" name="location" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="school_year" class="block text-gray-700">School Year</label>
                <input type="text" id="school_year" name="school_year" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="semester_id" class="block text-gray-700">Semester</label>
                <select id="semester_id" name="semester_id" class="form-select mt-1 block w-full">
                    <option value="">Select Semester</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Activity</button>
        </form>
    </div>
    @endsection

    </x-officer-app-layout>
