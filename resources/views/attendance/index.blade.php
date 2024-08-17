@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <h2 class="text-3xl font-bold text-[#5C0E0F] text-center mb-6">My Attendance Records</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#5C0E0F] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Activity Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Time In</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Time Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($attendances as $attendance)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->activity->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i') : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i') : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('sAttendance.show', $attendance->id) }}" class="text-[#5C0E0F] hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No attendance records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $attendances->links('pagination::tailwind') }}
    </div>
</div>
@endsection
