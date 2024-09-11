<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto mt-4 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Manage Attendance</h1>

        <!-- Form to Filter by Activity, Name, and School ID -->
        <form method="GET" action="{{ route('attendance.index') }}" id="filter-form" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

                <!-- Name Filter -->
                <div class="mb-4">
                    <label for="search_name" class="block text-sm font-medium text-gray-700">Student Name</label>
                    <input type="text" name="search_name" id="search_name" value="{{ request('search_name') }}" placeholder="Enter name" class="form-control mt-1 block w-full" autocomplete="off">
                </div>

                <!-- School ID Filter -->
                <div class="mb-4">
                    <label for="search_school_id" class="block text-sm font-medium text-gray-700">School ID</label>
                    <input type="text" name="search_school_id" id="search_school_id" value="{{ request('search_school_id') }}" placeholder="Enter School ID" class="form-control mt-1 block w-full" autocomplete="off">
                </div>
            </div>
        </form>

        <!-- Barcode Scanning Area -->
        @if($filterActivity)
            <div class="mb-4 p-4 bg-gray-100 border border-gray-300 rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Scan Barcode to Record Attendance</h2>
                <form id="barcode-scan-form" method="POST" action="{{ route('attendance.mark') }}">
                    @csrf
                    <input type="hidden" name="filter_activity" value="{{ $filterActivity }}">

                    <!-- Barcode Input -->
                    <input type="text" id="barcode-input" name="scanned_id" placeholder="Scan ID here" class="form-control block w-full text-lg p-2" autocomplete="off" autofocus>
                </form>
                <!-- Error Alert -->
                <div id="error-message" class="hidden mt-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg"></div>
            </div>

            <!-- Attendance Records Table -->
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
                                    <a href="{{ route('attendance.edit', $attendance->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-2 text-center">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $attendances->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

    @section('scripts')
    <script>
        // Automatically focus on the barcode input
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('barcode-input').focus();
        });

        // Automatically submit the form once a barcode is scanned
        document.getElementById('barcode-input').addEventListener('input', function () {
            let scannedId = this.value.trim();
            console.log('Scanned ID:', scannedId); // Log the scanned ID here
            if (scannedId) {
                document.getElementById('barcode-scan-form').submit();
            }
        });

        // Trigger form submission for filters automatically as the user types
        const debounce = (callback, delay) => {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => callback.apply(this, args), delay);
            };
        };

        document.getElementById('search_name').addEventListener('input', debounce(function () {
            document.getElementById('filter-form').submit();
        }, 300));

        document.getElementById('search_school_id').addEventListener('input', debounce(function () {
            document.getElementById('filter-form').submit();
        }, 300));

        // Handle form submission response
        document.getElementById('barcode-scan-form').addEventListener('submit', function (event) {
            event.preventDefault();
            const form = this;
            const errorMessageElement = document.getElementById('error-message');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(new FormData(form))
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        errorMessageElement.textContent = data.message;
                        errorMessageElement.classList.remove('hidden');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.message) {
                    alert(data.message); // Show success alert
                    window.location.reload(); // Reload to see updated records
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
    @endsection
    @endsection
</x-officer-app-layout>
