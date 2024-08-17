<x-officer-app-layout>

    @section('content')

    <div class="container mx-auto p-4">

        <div class="flex justify-end mb-4">
            <a href="{{ route('students.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create New Student</a>
        </div>

 <!-- Search and Filter Form -->
<div class="mb-4">
    <form id="filter-form">
        <input type="text" id="name" name="name" placeholder="Search by Name">
        <input type="text" id="school_id" name="school_id" placeholder="Search by School ID">

        <select id="organization" name="organization">
            <option value="">Select Organization</option>
            @foreach($organizations as $organization)
                <option value="{{ $organization->name }}">{{ $organization->name }}</option>
            @endforeach
        </select>

        <select id="course" name="course">
            <option value="">Select Course</option>
            @foreach($courses as $course)
                <option value="{{ $course->name }}">{{ $course->name }}</option>
            @endforeach
        </select>

        <select id="sort_year" name="sort_year">
            <option value="">Sort by Year</option>
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
    </form>
</div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border-b">#</th>
                        <th class="px-4 py-2 border-b">School ID</th>
                        <th class="px-4 py-2 border-b">Student Name</th>
                        <th class="px-4 py-2 border-b">Organization</th>
                        <th class="px-4 py-2 border-b">Course</th>
                        <th class="px-4 py-2 border-b">Year</th>
                        <th class="px-4 py-2 border-b">Image</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startNumber = ($users->currentPage() - 1) * $users->perPage() + 1;
                    @endphp
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b text-center">{{ $startNumber++ }}</td>
                            <td class="px-4 py-2 border-b text-center">{{ $user->school_id }}</td>
                            <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $user->organization ? $user->organization->name : 'N/A' }}</td>
                            <td class="px-4 py-2 border-b">{{ $user->course ? $user->course->name : 'N/A' }}</td>
                            <td class="px-4 py-2 border-b text-center">{{ $user->year ? $user->year->name : 'N/A' }}</td>
                            <td class="px-4 py-2 border-b text-center">
                                @if($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="Student Image" class="w-16 h-16 object-cover">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b text-center">
                                <a href="{{ route('students.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a> |
                                <form action="{{ route('students.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    @endsection

    <script>
        $(document).ready(function() {
            function fetchStudents() {
                $.ajax({
                    url: "{{ route('students.index') }}",
                    method: "GET",
                    data: {
                        name: $('#name').val(),
                        school_id: $('#school_id').val(),
                        organization: $('#organization').val(),
                        course: $('#course').val(), // Include course in AJAX request
                        sort_year: $('#sort_year').val(),
                    },
                    success: function(data) {
                        $('tbody').html(data.html);
                        $('.pagination').html(data.pagination);
                    }
                });
            }

            $('#name, #school_id, #organization, #course, #sort_year').on('input change', function() {
                fetchStudents();
            });
        });
        </script>

    </x-officer-app-layout>
