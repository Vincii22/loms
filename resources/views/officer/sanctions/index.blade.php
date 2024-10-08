<x-officer-app-layout>
    @section('content')
        <x-slot name="header">
            <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
                {{ __('Officer') }} /
            <a href="{{ route('sanctions.index') }}" class="text-indigo-600 uppercase">MANAGE SANCTION</a>
        </a>
        </x-slot>
    <div class="overflow-x-auto">
        <form method="GET" action="{{ route('sanctions.index') }}" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Semester Filter -->
                <div>
                    <label for="filter_semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select id="filter_semester" name="filter_semester" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Semesters</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ request('filter_semester') == $semester->id ? 'selected' : '' }}>
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
                        @foreach ($schoolYears as $year)
                            <option value="{{ $year }}" {{ request('filter_school_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sanction Type Filter -->
                <div>
                    <label for="filter_type" class="block text-sm font-medium text-gray-700">Sanction Type</label>
                    <select id="filter_type" name="filter_type" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Types</option>
                        @foreach ($sanctionTypes as $type)
                            <option value="{{ $type }}" {{ request('filter_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <div class="overflow-x-auto bg-white p-5 rounded shadow-sm">
            <table id="userTable" class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-2 px-4 border-b">School ID</th>
                        <th class="py-2 px-4 border-b">Student</th>
                        <th class="py-2 px-4 border-b">Type</th>
                        <th class="py-2 px-4 border-b">Fine Amount</th>
                        <th class="py-2 px-4 border-b">Required Action</th>
                        <th class="py-2 px-4 border-b">Resolved</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sanctions as $sanction)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $sanction->student->school_id ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->student->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->type }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->fine_amount ? number_format($sanction->fine_amount, 2) : 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->required_action ?: 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->resolved == 'resolved' ? 'Yes' : 'No' }}</td>
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
                        <td colspan="7" class="py-2 px-4 border-b text-center text-gray-500">No sanctions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $sanctions->links('pagination::tailwind') }}
            </div>
        </div>
    </div>


    <script>
        // Add event listener for text inputs
        document.querySelectorAll('input[type="text"]').forEach(input => {
            input.addEventListener('input', function() {
                var searchParams = new URLSearchParams(window.location.search);
                searchParams.set(this.name, this.value);
                window.location.href = "{{ route('sanctions.index') }}?" + searchParams.toString();
            });
        });

        // Add event listener for select inputs
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', function() {
                var searchParams = new URLSearchParams(window.location.search);
                searchParams.set(this.name, this.value);
                window.location.href = "{{ route('sanctions.index') }}?" + searchParams.toString();
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
        
        .dt-buttons{
            display: none !important;
        }

        .dataTables_filter{
            margin-bottom: 20px;
        }
    </style>
    @endsection
</x-officer-app-layout>
