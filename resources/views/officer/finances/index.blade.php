<x-officer-app-layout>
    @section('content')
    <div id="alert" class="bg-[maroon] text-white p-2 rounded mb-4 shadow-md flex items-center justify-between {{ session('error') ? '' : 'hidden' }}" role="alert">
        <span class="text-white">{{ session('error') }}</span>
    </div>

    <div class="container mx-auto mt-4 ">
        <x-slot name="header">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ __('Officer') }} /
                <a href="{{ route('fees.index') }}" class="text-black hover:underline">FINANCE /</a>
                <a href="{{ route('finances.index') }}" class="text-indigo-600">MANAGE FINANCE</a>
            </h2>
        </x-slot>
        <div class="bg-white shadow-md rounded-lg p-5">
            <form method="GET" action="{{ route('finances.index') }}" class="mb-4">
                <!-- Select Fee Dropdown -->
                <div class="mb-4">
                    <label for="fee_id" class="block text-sm font-medium text-gray-700">Select Fee</label>
                    <select name="fee_id" id="fee_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Fee</option>
                        @foreach($fees as $fee)
                            <option value="{{ $fee->id }}" {{ request('fee_id') == $fee->id ? 'selected' : '' }}>
                                {{ $fee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Other Filters -->
                <div class="flex flex-wrap -mx-2 mb-4">
                    <!-- Search by Name -->
                    <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4">
                        <label for="search_name" class="block text-sm font-medium text-gray-700">Search by Name</label>
                        <input type="text" name="search_name" id="search_name" placeholder="Search by name" value="{{ request('search_name') }}" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Search by School ID -->
                    <div class="w-full md:w-1/2 lg:w-1/4 px-2 mb-4">
                        <label for="search_school_id" class="block text-sm font-medium text-gray-700">Search by School ID</label>
                        <input type="text" name="search_school_id" id="search_school_id" placeholder="Search by school ID" value="{{ request('search_school_id') }}" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>
            </form>
        </div>

        @if($finances->count())
            <div class="overflow-x-auto bg-white rounded shadow-sm p-5 mt-5">
                <table id="userTable" class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Officer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finances as $finance)
                            <tr class="border-b">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->user->school_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->fee->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->default_amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $finance->status }}</td>
                                <td>{{ $finance->officer->role->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('finances.edit', $finance->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600" onclick="showAlert(event)">Edit</a>
                                    <form action="{{ route('finances.destroy', $finance->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $finances->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <p class="text-center mt-4">No finance records found.</p>
        @endif
    </div>
    @endsection

    <script>
        document.getElementById('fee_id').addEventListener('change', function() {
            var feeId = this.value;
            var searchParams = new URLSearchParams(window.location.search);
            searchParams.set('fee_id', feeId);
            window.location.href = "{{ route('finances.index') }}?" + searchParams.toString();
        });

        document.querySelectorAll('input[type="text"]').forEach(input => {
            input.addEventListener('input', function() {
                var searchParams = new URLSearchParams(window.location.search);
                searchParams.set(this.name, this.value);
                window.location.href = "{{ route('finances.index') }}?" + searchParams.toString();
            });
        });


        window.addEventListener('load', function() {
    const showAlert = localStorage.getItem('showAlert');
    console.log('showAlert:', showAlert); // Check if the item is correctly retrieved
    if (showAlert === 'true') {
        localStorage.removeItem('showAlert');
        const alert = document.getElementById('alert');
        if (alert) {
            alert.classList.remove('hidden');
            alert.classList.add('block');
            console.log('Alert is shown'); // Confirm the alert is shown

            setTimeout(function() {
                alert.classList.remove('block');
                alert.classList.add('hidden');
                console.log('Alert is hidden'); // Confirm the alert is hidden after delay
            }, 3000); // 3 seconds
        }
    }
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
</x-officer-app-layout>
