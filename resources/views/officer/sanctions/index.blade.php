<x-officer-app-layout>
    @section('content')
    <div class="overflow-x-auto">
        <form method="GET" action="{{ route('sanctions.index') }}" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                <!-- Student Name Search -->
                <div>
                    <label for="search_name" class="block text-sm font-medium text-gray-700">Student Name</label>
                    <input type="text" id="search_name" name="search_name" value="{{ request('search_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Search by student name">
                </div>

                <!-- School ID Search -->
                <div>
                    <label for="search_school_id" class="block text-sm font-medium text-gray-700">School ID</label>
                    <input type="text" id="search_school_id" name="search_school_id" value="{{ request('search_school_id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Search by school ID">
                </div>

                <!-- Organization Filter -->
                <div>
                    <label for="filter_organization" class="block text-sm font-medium text-gray-700">Organization</label>
                    <select id="filter_organization" name="filter_organization" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Organizations</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ request('filter_organization') == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Course Filter -->
                <div>
                    <label for="filter_course" class="block text-sm font-medium text-gray-700">Course</label>
                    <select id="filter_course" name="filter_course" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ request('filter_course') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Filter -->
                <div>
                    <label for="filter_year" class="block text-sm font-medium text-gray-700">Year</label>
                    <select id="filter_year" name="filter_year" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Years</option>
                        @foreach ($years as $year)
                            <option value="{{ $year->id }}" {{ request('filter_year') == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Filter Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition">Apply Filters</button>
            </div>
        </form>

        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Student</th>
                    <th class="py-2 px-4 border-b">Type</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Fine Amount</th>
                    <th class="py-2 px-4 border-b">Required Action</th>
                    <th class="py-2 px-4 border-b">Resolved</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sanctions as $sanction)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $sanction->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $sanction->student->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $sanction->type }}</td>
                    <td class="py-2 px-4 border-b">{{ $sanction->description }}</td>
                    <td class="py-2 px-4 border-b">{{ $sanction->fine_amount ? number_format($sanction->fine_amount, 2) : 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $sanction->required_action ?: 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $sanction->resolved ? 'Yes' : 'No' }}</td>
                    <td class="py-2 px-4 border-b flex space-x-2">
                        <a href="{{ route('sanctions.edit', $sanction->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition text-xs">Edit</a>
                        <form action="{{ route('sanctions.destroy', $sanction->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition text-xs" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-2 px-4 border-b text-center text-gray-500">No sanctions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $sanctions->links('pagination::tailwind') }}
    </div>
    @endsection
</x-officer-app-layout>
