<x-officer-app-layout>
    @section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Archived Activities') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
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
                        <th class="px-6 py-3 border-b">Start Time</th>
                        <th class="px-6 py-3 border-b">End Time</th>
                        <th class="px-6 py-3 border-b">Location</th>
                        <th class="px-6 py-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($archivedActivities as $activity)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b">{{ $activity->name }}</td>
                            <td class="px-6 py-4 border-b">{{ \Carbon\Carbon::parse($activity->start_time)->format('F j, Y g:i A') }}</td>
                            <td class="px-6 py-4 border-b">{{ \Carbon\Carbon::parse($activity->end_time)->format('F j, Y g:i A') }}</td>
                            <td class="px-6 py-4 border-b">{{ $activity->location }}</td>
                            <td class="px-5 py-4 border-b text-center">
                                <form action="{{ route('activities.unarchive', $activity->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 text-white px-[.55rem] py-1 rounded-lg shadow hover:bg-blue-600 transition text-xs" onclick="return confirm('Are you sure you want to unarchive this activity?')">Unarchive</button>
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
