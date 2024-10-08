<x-officer-app-layout>

    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ __('Officer') }} /
                <a href="{{ route('clearances.index') }}" class="text-black hover:underline uppercase">Manage Activities</a>
            </h2>
        </x-slot>
    <div class="container mx-auto px-4 py-6">

        <!-- Filter Form -->
        <form method="GET" action="{{ route('activities.index') }}" class="mb-4">
            <div class="flex space-x-4">
                <!-- Semester Filter -->
                <div class="flex-1">
                    <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select id="semester_id" name="semester_id" class="form-select mt-1 block w-full">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- School Year Filter -->
                <div class="flex-1">
                    <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <input type="text" id="school_year" name="school_year" value="{{ request('school_year') }}" class="form-input mt-1 block w-full" placeholder="Enter school year">
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                </div>
            </div>
        </form>

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
                        <!-- <th class="px-6 py-3 border-b">Description</th> -->
                        <th class="px-6 py-3 border-b">Start Time</th>
                        <th class="px-6 py-3 border-b">End Time</th>
                        <th class="px-6 py-3 border-b">Location</th>
                        <th class="px-6 py-3 border-b">School Year</th>
                        <th class="px-6 py-3 border-b">Semester</th>
                        <th class="px-6 py-3 border-b w-[150px]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b">{{ $activity->name }}</td>
                            <!-- <td class="px-6 py-4 border-b">{{ $activity->description }}</td> -->
                            <td class="px-6 py-4 border-b">{{ \Carbon\Carbon::parse($activity->start_time)->format('F j, Y g:i A') }}</td>
                            <td class="px-6 py-4 border-b">{{ \Carbon\Carbon::parse($activity->end_time)->format('F j, Y g:i A') }}</td>
                            <td class="px-6 py-4 border-b">{{ $activity->location }}</td>
                            <td class="px-6 py-4 border-b">{{ $activity->school_year }}</td>
                            <td class="px-6 py-4 border-b">{{ $activity->semester->name ?? 'N/A' }}</td>
                            <td class="px-5 py-4 border-b text-center">
                                <a href="{{ route('activities.edit', $activity->id) }}" class="bg-yellow-500 text-white px-[.55rem] py-1 rounded-lg shadow hover:bg-yellow-600 transition text-xs">Edit</a>
                                |
                                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-[.55rem] py-1 rounded-lg shadow hover:bg-red-600 transition text-xs"" onclick="return confirm('Are you sure?')">Delete</button>
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
