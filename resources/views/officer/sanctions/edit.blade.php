<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto px-4 mt-6">
        <h1 class="text-2xl font-bold mb-6">Edit Sanction</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white rounded-lg p-4 mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sanctions.update', $sanction->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <!-- Read-only fields -->
            <div class="mb-4">
                <label for="student_name" class="block text-gray-700 font-semibold mb-2">Student Name</label>
                <input type="text" name="student_name" id="student_name" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $sanction->student->name }}" readonly>
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-semibold mb-2">Type</label>
                <input type="text" name="type" id="type" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $sanction->type }}" readonly>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" id="description" class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4" readonly>{{ $sanction->description }}</textarea>
            </div>

            <!-- Editable fields -->
            <div class="mb-4">
                <label for="fine_amount" class="block text-gray-700 font-semibold mb-2">Fine Amount</label>
                <input type="number" step="0.01" name="fine_amount" id="fine_amount" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('fine_amount', $sanction->fine_amount) }}">
            </div>

            <div class="mb-4">
                <label for="required_action" class="block text-gray-700 font-semibold mb-2">Required Action</label>
                <textarea name="required_action" id="required_action" class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4">{{ old('required_action', $sanction->required_action) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="resolved" class="block text-gray-700 font-semibold mb-2">Resolved Status</label>
                <select name="resolved" id="resolved" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="not resolved" {{ $sanction->resolved == 'not resolved' ? 'selected' : '' }}>Not Resolved</option>
                    <option value="resolved" {{ $sanction->resolved == 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition">Update Sanction</button>
        </form>

        <script>
            // JavaScript for resolving sanction and calling updateClearanceStatus
            document.querySelector('form').addEventListener('submit', function(event) {
                event.preventDefault();

                const resolved = document.querySelector('#resolved').checked;

                // Proceed with form submission after updating clearance status
                if (resolved) {
                    // Call the updateClearanceStatus method via an AJAX request or trigger it server-side
                        .then(response => {
                            this.submit(); // Submit the form once clearance status is updated
                        })
                        .catch(error => {
                            console.error('Error updating clearance status:', error);
                            alert('There was an issue updating the clearance status.');
                        });
                } else {
                    this.submit(); // Directly submit if the sanction is not marked as resolved
                }
            });
        </script>
    </div>
    @endsection
</x-officer-app-layout>
