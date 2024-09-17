<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-semibold text-center mb-8">Sanction Report</h1>

        <!-- Filter Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h4 class="text-lg font-medium mb-4">Filter Sanctions</h4>
            <form method="GET" action="{{ route('reports.sanction') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <select name="semester" id="semester" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Semesters</option>
                            @foreach($semesters as $id => $name)
                                <option value="{{ $id }}" {{ request('semester') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <select name="school_year" id="school_year" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All School Years</option>
                            @foreach($schoolYears as $year)
                                <option value="{{ $year }}" {{ request('school_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="resolved" class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <select name="resolved" id="resolved" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Statuses</option>
                            <option value="resolved" {{ request('resolved') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="not resolved" {{ request('resolved') == 'not resolved' ? 'selected' : '' }}>Not Resolved</option>
                        </select>
                    </div>
                </div>

                <div class="col-span-full flex justify-end mt-4">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Sanctions Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white text-sm">
                    <tr class="text-center">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Student Name</th>
                        <th class="px-4 py-2">Semester</th>
                        <th class="px-4 py-2">School Year</th>
                        <th class="px-4 py-2">Fine Amount</th>
                        <th class="px-4 py-2">Required Action</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sanctions as $sanction)
                        <tr class="text-center hover:bg-gray-100">
                            <td class="px-4 py-3">{{ $sanction->id }}</td>
                            <td class="px-4 py-3">{{ $sanction->student->name }}</td>
                            <td class="px-4 py-3">{{ $sanction->semester->name }}</td>
                            <td class="px-4 py-3">{{ $sanction->school_year }}</td>
                            <td class="px-4 py-3">P{{ number_format($sanction->fine_amount, 2) }}</td>
                            <td class="px-4 py-3">{{ $sanction->required_action }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sanction->resolved == 'resolved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($sanction->resolved) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No sanctions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $sanctions->links() }}
        </div>
    </div>
    @endsection
</x-officer-app-layout>
