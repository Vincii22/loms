<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto mt-4 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Manage Attendance</h1>

        <form method="GET" action="{{ route('attendance.index') }}" class="mb-4">
            <div class="mb-4">
                <label for="filter_activity" class="block text-sm font-medium text-gray-700">Select Activity</label>
                <select name="filter_activity" id="filter_activity" class="form-control mt-1 block w-full" onchange="this.form.submit()">
                    <option value="">Select Activity</option>
                    @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ request('filter_activity') == $activity->id ? 'selected' : '' }}>
                            {{ $activity->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if($filterActivity)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr class="border-b">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->activity->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('g:i A') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('g:i A') : '-' }}</td>
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

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $attendances->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
    @endsection
</x-officer-app-layout>
