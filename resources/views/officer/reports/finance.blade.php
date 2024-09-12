<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Finance Report</h1>

        <!-- Filters Form -->
        <form method="GET" action="{{ route('reports.finance') }}" class="mb-6 p-4 bg-white shadow-md rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="form-group">
                    <label for="fee_id" class="block text-sm font-medium text-gray-700">Fee</label>
                    <select name="fee_id" id="fee_id" class="form-select block w-full mt-1">
                        <option value="">Select Fee</option>
                        @foreach($fees as $id => $name)
                            <option value="{{ $id }}" {{ request('fee_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester" id="semester" class="form-select block w-full mt-1">
                        <option value="">Select Semester</option>
                        @foreach($semesters as $id => $semester)
                            <option value="{{ $id }}" {{ request('semester') == $id ? 'selected' : '' }}>{{ $semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <input type="text" name="school_year" id="school_year" class="form-input block w-full mt-1" value="{{ request('school_year') }}" placeholder="Enter School Year">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <!-- Finance Report Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($finances as $finance)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $finance->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $finance->student_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $finance->school_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $finance->fee_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $finance->semester_id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $finance->school_year }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $finance->default_amount }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $finance->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $finances->links() }}
        </div>
    </div>
    @endsection
    </x-officer-app-layout>
