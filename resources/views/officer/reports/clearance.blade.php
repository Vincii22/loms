<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-semibold text-center mb-8">Clearance Report</h1>

        <!-- Filter Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <form method="GET" action="{{ route('reports.clearance') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="date_range" class="block text-sm font-medium text-gray-700">Date Range</label>
                    <input type="text" name="date_range" id="date_range" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="YYYY-MM-DD to YYYY-MM-DD" value="{{ request('date_range') }}">
                </div>

                <div class="col-span-full flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Clearance Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white text-sm">
                    <tr class="text-center">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">User Name</th>
                        <th class="px-4 py-2">School ID</th>
                        <th class="px-4 py-2">Semester</th>
                        <th class="px-4 py-2">School Year</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clearances as $clearance)
                    <tr class="text-center hover:bg-gray-100">
                        <td class="px-4 py-3">{{ $clearance->id }}</td>
                        <td class="px-4 py-3">{{ $clearance->user->name }}</td>
                        <td class="px-4 py-3">{{ $clearance->user->school_id }}</td>
                        <td class="px-4 py-3">{{ $clearance->semester ? $clearance->semester->name : 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $clearance->school_year }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clearance->status == 'cleared' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($clearance->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $clearances->links() }}
        </div>
    </div>
    @endsection
</x-officer-app-layout>
