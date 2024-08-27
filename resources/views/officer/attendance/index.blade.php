<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto mt-4 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Manage Attendance</h1>
        <form method="GET" action="{{ route('attendance.index') }}" class="mb-4">
            <!-- Filter by Activity -->
            <div class="mb-4">
                <label for="filter_activity" class="block text-sm font-medium text-gray-700">Select Activity</label>
                <select name="filter_activity" id="filter_activity" class="form-control mt-1 block w-full" onchange="this.form.submit()">
                    <option value="">Select Activity</option>
                    @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ request('filter_activity') == $activity->id ? 'selected' : '' }}>
                            {{ $activity->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Flex Container for Name and School ID Filters -->
            <div class="flex space-x-4 mb-4">
                <!-- Filter by Name -->
                <div class="flex-1">
                    <label for="search_name" class="block text-sm font-medium text-gray-700">Search by Name</label>
                    <input type="text" name="search_name" id="search_name" placeholder="Search by name" value="{{ request('search_name') }}" class="form-control mt-1 block w-full" />
                </div>

                <!-- Filter by School ID -->
                <div class="flex-1">
                    <label for="search_school_id" class="block text-sm font-medium text-gray-700">Search by School ID</label>
                    <input type="text" name="search_school_id" id="search_school_id" placeholder="Search by school ID" value="{{ request('search_school_id') }}" class="form-control mt-1 block w-full" />
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>



        <!-- Grouping Scan ID and Time Type in a single div with flex layout -->
        <div class="mb-4 p-4 bg-gray-100 border border-gray-300 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Take Attendance</h2>

            <div class="flex gap-4 items-center mb-4">
                <div class="flex-1">
                    <label for="time_type" class="block text-sm font-medium text-gray-700">Select Time Type</label>
                    <select name="time_type" id="time_type" class="form-control mt-1 block w-48"> <!-- Shortened width -->
                        <option value="time_in">Time In</option>
                        <option value="time_out">Time Out</option>
                    </select>
                </div>

                <button id="scan-id-button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-32"> <!-- Shortened width -->
                    Scan ID
                </button>
            </div>

            <!-- Include a hidden input to store the scanned ID -->
            <input type="hidden" id="scanned-id" name="scanned_id">
        </div>

        @if($filterActivity)
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Student ID</th>
                            <th class="px-4 py-2">Student Name</th>
                            <th class="px-4 py-2">Activity</th>
                            <th class="px-4 py-2">Time In</th>
                            <th class="px-4 py-2">Time Out</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th> <!-- Added Actions column -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td class="px-4 py-2">{{ $attendance->user->school_id }}</td>
                                <td class="px-4 py-2">{{ $attendance->user->name }}</td>
                                <td class="px-4 py-2">{{ $attendance->activity->name }}</td>
                                <td class="px-4 py-2">{{ $attendance->time_in }}</td>
                                <td class="px-4 py-2">{{ $attendance->time_out }}</td>
                                <td class="px-4 py-2">{{ $attendance->status }}</td>
                                <td class="px-4 py-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('attendance.edit', $attendance->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-2 text-center">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $attendances->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div id="student-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
            <h2 class="text-xl font-bold mb-4" id="student-name"></h2>
            <img id="student-image" src="" alt="Student Image" class="w-24 h-24 mb-4">
            <p><strong>Course:</strong> <span id="student-course"></span></p>
            <p><strong>Year:</strong> <span id="student-year"></span></p>
            <p><strong>Organization:</strong> <span id="student-organization"></span></p>
            <p><strong>School ID:</strong> <span id="student-school-id"></span></p>
            <p><strong>Barcode:</strong> <span id="student-barcode"></span></p>
            <form id="confirm-attendance-form" method="POST" action="{{ route('attendance.confirm') }}">
                @csrf
                <input type="hidden" id="modal-scanned-id" name="scanned_id">
                <input type="hidden" id="modal-time-type" name="time_type">
                <input type="hidden" id="modal-filter-activity" name="filter_activity" value="{{ request('filter_activity') }}">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Confirm Attendance</button>
            </form>
            <button id="modal-close" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Close</button>
        </div>
    </div>

    @section('scripts')
    <script>
        document.getElementById('scan-id-button').addEventListener('click', function() {
            let scannedId = prompt("Please scan your ID");
            if (scannedId) {
                let timeType = document.getElementById('time_type').value; // Get selected time type
                document.getElementById('scanned-id').value = scannedId;

                // Populate modal fields
                document.getElementById('modal-scanned-id').value = scannedId;
                document.getElementById('modal-time-type').value = timeType;

                // Make an AJAX request to get user details
                fetch(`{{ route('attendance.mark') }}?scanned_id=${scannedId}&filter_activity={{ request('filter_activity') }}&time_type=${timeType}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    // Check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        return response.text().then(text => {
                            throw new Error(`Expected JSON, but received: ${text}`);
                        });
                    }
                })
                .then(data => {
                    console.log("Response Data:", data); // Log response data for debugging
                    if (data.user) {
                        // Display student details in the modal
                        document.getElementById('student-name').textContent = data.user.name;

                        const imageUrl = data.user.image ? `{{ asset('storage/${data.user.image}') }}` : 'default-image-url'; // Adjust if needed
                        document.getElementById('student-image').src = imageUrl;
                        document.getElementById('student-course').textContent = data.user.course;
                        document.getElementById('student-year').textContent = data.user.year;
                        document.getElementById('student-organization').textContent = data.user.organization;
                        document.getElementById('student-school-id').textContent = data.user.school_id;
                        document.getElementById('student-barcode').textContent = scannedId;

                        // Show the modal
                        document.getElementById('student-modal').classList.remove('hidden');
                    } else {
                        alert(data.message); // Notify if no user data found
                    }
                })
                .catch(error => {
                    console.error('Error:', error); // Log any errors
                });
            }
        });

        document.getElementById('modal-close').addEventListener('click', function() {
            document.getElementById('student-modal').classList.add('hidden');
        });
    </script>
    @endsection
    @endsection
</x-officer-app-layout>
