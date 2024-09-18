<x-officer-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
            {{ __('Officer') }} /
            <a href="{{ route('reports.sanction') }}" class="text-indigo-600 uppercase">sanction REPORT</a>
        </a>
    </x-slot>
    <div class="container mx-auto">
            <form method="GET" action="{{ route('reports.sanction') }}" class="">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="w-full">
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

                    <div class="w-full">
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

                    <div class="w-full">
                        <label for="resolved" class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <select name="resolved" id="resolved" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">All Statuses</option>
                                <option value="resolved" {{ request('resolved') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="not resolved" {{ request('resolved') == 'not resolved' ? 'selected' : '' }}>Not Resolved</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                     Filter
                </button>
            </form>

        <!-- Sanctions Table -->
        <div class="overflow-x-auto bg-white p-5 rounded shadow-sm mt-5">
            <table id="userTable" class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fine Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Required Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sanctions as $sanction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sanction->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sanction->student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sanction->semester->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sanction->school_year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">P{{ number_format($sanction->fine_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sanction->required_action }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
            <div class="mt-6">
                {{ $sanctions->links() }}
            </div>
        </div>

        <!-- Pagination Links -->
        
    </div>
    @endsection
    <style>
        .dataTables_paginate{
            display: none !important;
        }
        
        .dataTables_info{
            display: none !important;

        }
    </style>
</x-officer-app-layout>
