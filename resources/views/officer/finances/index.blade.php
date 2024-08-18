<x-officer-app-layout>

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">
            Finance Management
        </h1>


        <!-- Fee filter or selection -->
        {{-- <div class="mb-4">
            <label for="fee_id" class="block text-sm font-medium text-gray-700">Filter by Fee</label>
            <select id="fee_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">All Fees</option>
                @foreach ($fees as $feeOption)
                    <option value="{{ $feeOption->id }}" {{ request('fee_id') == $feeOption->id ? 'selected' : '' }}>
                        {{ $feeOption->name }}
                    </option>
                @endforeach
            </select>
        </div> --}}

        <a href="{{ route('finances.create') }}" class="bg-[#5C0E0F] text-white px-4 py-2 rounded-md hover:bg-[#470A0B]">Create New Entry</a>

        <form method="GET" action="{{ route('finances.index') }}">
            <input type="text" name="search_name" placeholder="Search by name" value="{{ request('search_name') }}">
            <input type="text" name="search_school_id" placeholder="Search by school ID" value="{{ request('search_school_id') }}">

            <select name="filter_organization">
                <option value="">Select Organization</option>
                @foreach($organizations as $organization)
                    <option value="{{ $organization->id }}" {{ request('filter_organization') == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                @endforeach
            </select>

            <select name="filter_course">
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('filter_course') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                @endforeach
            </select>

            <select name="filter_year">
                <option value="">Select Year</option>
                @foreach($years as $year)
                    <option value="{{ $year->id }}" {{ request('filter_year') == $year->id ? 'selected' : '' }}>{{ $year->year }}</option>
                @endforeach
            </select>

            <select name="fee_id">
                <option value="">Select Fee</option>
                @foreach($fees as $fee)
                    <option value="{{ $fee->id }}" {{ request('fee_id') == $fee->id ? 'selected' : '' }}>{{ $fee->name }}</option>
                @endforeach
            </select>

            <button type="submit">Filter</button>
        </form>


        <table class="min-w-full divide-y divide-gray-200 mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Fee</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($finances as $finance)
                    <tr>
                        <td>{{ $finance->id }}</td>
                        <td>{{ $finance->user->name }}</td>
                        <td>{{ $finance->fee->name }}</td>
                        <td>{{ $finance->default_amount }}</td>
                        <td>{{ $finance->status }}</td>
                        <td>
                            <a href="{{ route('finances.edit', $finance->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form action="{{ route('finances.destroy', $finance->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script>
            document.getElementById('fee_id').addEventListener('change', function() {
            var feeId = this.value;
            var searchParams = new URLSearchParams(window.location.search);
            searchParams.set('fee_id', feeId);
            window.location.href = "{{ route('finances.index') }}?" + searchParams.toString();
        });
    </script>
</x-officer-app-layout>
