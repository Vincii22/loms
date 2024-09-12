<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto p-4">

        <!-- Button for creating new student -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('students.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create New Student</a>
        </div>

        <!-- Search and Filter Form -->
        <div class="mb-4">
            <input type="text" id="name" name="name" placeholder="Search by Name" class="form-control mb-2">
            <input type="text" id="school_id" name="school_id" placeholder="Search by School ID" class="form-control mb-2">

            <select id="organization" name="organization" class="form-control mb-2">
                <option value="">Select Organization</option>
                @foreach($organizations as $organization)
                    <option value="{{ $organization->name }}">{{ $organization->name }}</option>
                @endforeach
            </select>

            <select id="course" name="course" class="form-control mb-2">
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->name }}">{{ $course->name }}</option>
                @endforeach
            </select>

            <select id="sort_year" name="sort_year" class="form-control mb-2">
                <option value="">Sort by Year</option>
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function fetchStudents() {
                const query = new URLSearchParams({
                    name: document.getElementById('name').value,
                    school_id: document.getElementById('school_id').value,
                    organization: document.getElementById('organization').value,
                    course: document.getElementById('course').value,
                    sort_year: document.getElementById('sort_year').value,
                }).toString();

                fetch(`{{ route('students.index') }}?${query}`)
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('tbody').innerHTML = data.html;
                        document.querySelector('.pagination').innerHTML = data.pagination;
                    })
                    .catch(error => {
                        console.error('Error fetching students:', error);
                    });
            }

            function debounce(func, delay) {
                let timeout;
                return function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, arguments), delay);
                };
            }

            const inputs = document.querySelectorAll('#name, #school_id, #organization, #course, #sort_year');
            inputs.forEach(input => input.addEventListener('input', debounce(fetchStudents, 300)));
        });
    </script>
    @endsection
</x-officer-app-layout>
