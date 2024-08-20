<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto mt-4 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Finance Management</h1>

        <form method="GET" action="{{ route('finances.index') }}" class="mb-4">
            <!-- Select Fee Dropdown in a Separate Div -->
            <div class="mb-4">
                <label for="fee_id" class="block text-sm font-medium text-gray-700">Select Fee</label>
                <select name="fee_id" id="fee_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Select Fee</option>
                    @foreach($fees as $fee)
                        <option value="{{ $fee->id }}" {{ request('fee_id') == $fee->id ? 'selected' : '' }}>
                            {{ $fee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Other Filters in a Flex Layout -->
            <div class="flex flex-wrap -mx-2 mb-4">
                <!-- Search by Name -->
                <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4">
                    <label for="search_name" class="block text-sm font-medium text-gray-700">Search by Name</label>
                    <input type="text" name="search_name" id="search_name" placeholder="Search by name" value="{{ request('search_name') }}" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Search by School ID -->
                <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4">
                    <label for="search_school_id" class="block text-sm font-medium text-gray-700">Search by School ID</label>
                    <input type="text" name="search_school_id" id="search_school_id" placeholder="Search by school ID" value="{{ request('search_school_id') }}" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Select Organization -->
                <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4">
                    <label for="filter_organization" class="block text-sm font-medium text-gray-700">Select Organization</label>
                    <select name="filter_organization" id="filter_organization" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Organization</option>
                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ request('filter_organization') == $organization->id ? 'selected' : '' }}>
                                {{ $organization->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Course -->
                <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4">
                    <label for="filter_course" class="block text-sm font-medium text-gray-700">Select Course</label>
                    <select name="filter_course" id="filter_course" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('filter_course') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Year -->
                <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4">
                    <label for="filter_year" class="block text-sm font-medium text-gray-700">Select Year</label>
                    <select name="filter_year" id="filter_year" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Year</option>
                        @foreach($years as $year)
                            <option value="{{ $year->id }}" {{ request('filter_year') == $year->id ? 'selected' : '' }}>
                                {{ $year->year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="bg-[#5C0E0F] text-white px-4 py-2 rounded-md hover:bg-[#470A0B] mt-4">Filter</button>
        </form>

        @if($finances->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finances as $finance)
                            <tr class="border-b">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->fee->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->default_amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('finances.edit', $finance->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                                    <form action="{{ route('finances.destroy', $finance->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $finances->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <p class="text-center mt-4">No finance records found.</p>
        @endif
    </div>
    @endsection

    <script>
        document.getElementById('fee_id').addEventListener('change', function() {
            var feeId = this.value;
            var searchParams = new URLSearchParams(window.location.search);
            searchParams.set('fee_id', feeId);
            window.location.href = "{{ route('finances.index') }}?" + searchParams.toString();
        });
    </script>
</x-officer-app-layout>
