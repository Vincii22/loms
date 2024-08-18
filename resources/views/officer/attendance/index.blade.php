<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto mt-4 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Attendance Records</h1>
        <a href="{{ route('attendance.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-3">Add Attendance</a>
        <form method="GET" action="{{ route('attendance.index') }}">
            <input type="text" name="search_name" placeholder="Search by name" value="{{ request('search_name') }}">
            <input type="text" name="search_school_id" placeholder="Search by school ID" value="{{ request('search_school_id') }}">

            <select name="filter_organization">
                <option value="">Select Organization</option>
                @foreach($organizations as $organization)
                    <option value="{{ $organization->id }}" {{ request('filter_organization') == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                @endforeach
            </select>

            <select name="filter_course">
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('filter_course') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                @endforeach
            </select>

            <select name="filter_year">
                <option value="">Select Year</option>
                @foreach($years as $year)
                    <option value="{{ $year->id }}" {{ request('filter_year') == $year->id ? 'selected' : '' }}>{{ $year->year }}</option>
                @endforeach
            </select>

            <select name="filter_activity">
                <option value="">Select Activity</option>
                @foreach($activities as $activity)
                    <option value="{{ $activity->id }}" {{ request('filter_activity') == $activity->id ? 'selected' : '' }}>{{ $activity->name }}</option>
                @endforeach
            </select>

            <button type="submit">Filter</button>
        </form>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded relative">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 p-2" data-dismiss="alert" aria-label="Close">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr class="border-b">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->activity->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('g:i A') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('g:i A') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('attendance.edit', $attendance->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center px-6 py-4">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <!-- Pagination links -->
        <div class="mt-4">
            {{ $attendances->links() }}
        </div>
    </div>
    @endsection
</x-officer-app-layout>
