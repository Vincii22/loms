<x-officer-app-layout>

    @section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Activities</h1>
        <a href="{{ route('activities.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Add New Activity</a>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-md">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-6 py-3 border-b">Name</th>
                        <th class="px-6 py-3 border-b">Description</th>
                        <th class="px-6 py-3 border-b">Start Time</th>
                        <th class="px-6 py-3 border-b">End Time</th>
                        <th class="px-6 py-3 border-b">Location</th>
                        <th class="px-6 py-3 border-b">School Year</th>
                        <th class="px-6 py-3 border-b">Semester</th>
                        <th class="px-6 py-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b">{{ $activity->name }}</td>
                            <td class="px-6 py-4 border-b">{{ $activity->description }}</td>
                            <td class="px-6 py-4 border-b">{{ \Carbon\Carbon::parse($activity->start_time)->format('F j, Y g:i A') }}</td>
                            <td class="px-6 py-4 border-b">{{ \Carbon\Carbon::parse($activity->end_time)->format('F j, Y g:i A') }}</td>
                            <td class="px-6 py-4 border-b">{{ $activity->location }}</td>
                            <td class="px-6 py-4 border-b">{{ $activity->school_year }}</td>
                            <td class="px-6 py-4 border-b">{{ $activity->semester->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 border-b text-center">
                                <a href="{{ route('activities.edit', $activity->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                |
                                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection

    </x-officer-app-layout>
