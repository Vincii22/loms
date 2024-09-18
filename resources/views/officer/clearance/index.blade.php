<x-officer-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ __('Officer') }} /
                <a href="{{ route('clearances.index') }}" class="text-black hover:underline uppercase">Clearance status</a>
            </h2>
        </x-slot>
    <div class="container mx-auto px-4 py-6">
        @if(session('success'))
            <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Form -->
        <form action="{{ route('clearances.index') }}" method="GET" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Semester Filter -->
                <div>
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
                <div>
                    <label for="filter_school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <select id="filter_school_year" name="filter_school_year" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All School Years</option>
                        @foreach($schoolYears as $year)
                            <option value="{{ $year }}" {{ request('filter_school_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="">
                    <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
                    <select id="status" name="status" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="not cleared" {{ request('status') === 'not cleared' ? 'selected' : '' }}>Not Cleared</option>
                        <option value="cleared" {{ request('status') === 'cleared' ? 'selected' : '' }}>Cleared</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto bg-white p-5 rounded shadow-sm">
            <table id="userTable" class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left text-gray-600">Name</th>
                        <th class="py-2 px-4 text-left text-gray-600">School ID</th>
                        <th class="py-2 px-4 text-left text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clearances as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->school_id }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                {{ $user->clearance ? $user->clearance->status : 'Not Set' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- @php
            // Debug output
            dd($clearances->toArray());
            @endphp --}}
            <div class="mt-6">
                {{ $clearances->links('pagination::tailwind') }}
            </div>
        </div>

        
    </div>

    <script>
        document.querySelectorAll('input[type="text"], select').forEach(input => {
            input.addEventListener('input', function() {
                var searchParams = new URLSearchParams(window.location.search);
                searchParams.set(this.name, this.value);
                window.location.href = "{{ route('clearances.index') }}?" + searchParams.toString();
            });
        });
    </script>

<style>
        .dataTables_paginate{
            display: none !important;
        }
        
        .dataTables_info{
            display: none !important;

        }
    </style>
    @endsection
</x-officer-app-layout>
