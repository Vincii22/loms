<x-officer-app-layout>

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">
            Finance Management
        </h1>

        <!-- Fee filter or selection -->
        <div class="mb-4">
            <label for="fee_id" class="block text-sm font-medium text-gray-700">Filter by Fee</label>
            <select id="fee_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">All Fees</option>
                @foreach ($fees as $feeOption)
                    <option value="{{ $feeOption->id }}" {{ request('fee_id') == $feeOption->id ? 'selected' : '' }}>
                        {{ $feeOption->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <a href="{{ route('finances.create') }}" class="bg-[#5C0E0F] text-white px-4 py-2 rounded-md hover:bg-[#470A0B]">Create New Entry</a>

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
                            <!-- Actions like Edit, Delete -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('fee_id').addEventListener('change', function() {
            var feeId = this.value;
            window.location.href = "{{ route('finances.index') }}?fee_id=" + feeId;
        });
    </script>
</x-officer-app-layout>
