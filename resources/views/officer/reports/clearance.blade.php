<x-officer-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
            {{ __('Officer') }} /
            <a href="{{ route('reports.clearance') }}" class="text-indigo-600 uppercase">clearance REPORT</a>
        </a>
    </x-slot>
    <div class="container mx-auto">
        <form method="GET" action="{{ route('reports.clearance') }}" >
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-3 mb-5 px-4">
                <div w-full>
                    <label for="date_range" class="block text-sm font-medium text-gray-700">Date Range</label>
                    <input type="text" name="date_range" id="date_range" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="YYYY-MM-DD to YYYY-MM-DD" value="{{ request('date_range') }}">
                </div>
                <div w-full>
                    <label for="date_range" class="block text-sm font-medium text-gray-700">Date Range</label>
                    <input type="text" name="date_range" id="date_range" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="YYYY-MM-DD to YYYY-MM-DD" value="{{ request('date_range') }}">
                </div>
                <div class="flex justify-end items-center h-full">
                    <button type="submit" class="inline-flex h-[40px] items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Filter
                    </button>
                </div>
            </div>
            
        </form>

        <!-- Clearance Table -->
        <div class="overflow-x-auto bg-white p-5 rounded shadow-sm">
            <table id="userTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clearances as $clearance)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $clearance->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $clearance->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $clearance->user->school_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $clearance->semester ? $clearance->semester->name : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $clearance->school_year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $clearance->status == 'cleared' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($clearance->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6 !bg-transparent">
                {{ $clearances->links() }}
            </div>
        </div>

        <!-- Pagination -->
        
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
