<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Clearance Status</h1>

        @if(session('success'))
            <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Form -->
        <form action="{{ route('clearances.index') }}" method="GET" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Student Name Search -->
                <div>
                    <label for="search_name" class="block text-sm font-medium text-gray-700">Student Name</label>
                    <input type="text" id="search_name" name="search_name" value="{{ request('search_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Search by student name">
                </div>

                <!-- School ID Search -->
                <div>
                    <label for="search_school_id" class="block text-sm font-medium text-gray-700">School ID</label>
                    <input type="text" id="search_school_id" name="search_school_id" value="{{ request('search_school_id') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Search by school ID">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
                    <select id="status" name="status" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="not eligible" {{ request('status') === 'not eligible' ? 'selected' : '' }}>Not Eligible</option>
                        <option value="cleared" {{ request('status') === 'cleared' ? 'selected' : '' }}>Cleared</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left text-gray-600">Name</th>
                        <th class="py-2 px-4 text-left text-gray-600">School ID</th>
                        <th class="py-2 px-4 text-left text-gray-600">Status</th>
                        <th class="py-2 px-4 text-left text-gray-600">Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clearances as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->school_id }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                {{ $user->clearance ? $user->clearance->status : 'Not Set' }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <form action="{{ route('clearances.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="form-select border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="not eligible" {{ $user->clearance && $user->clearance->status === 'not eligible' ? 'selected' : '' }}>Not Eligible</option>
                                        <option value="cleared" {{ $user->clearance && $user->clearance->status === 'cleared' ? 'selected' : '' }}>Cleared</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $clearances->links('pagination::tailwind') }}
        </div>
    </div>

    <script>
        document.querySelectorAll('input[type="text"], select').forEach(input => {
            input.addEventListener('input', function() {
                var searchParams = new URLSearchParams(window.location.search);
                searchParams.set(this.name, this.value);
                window.location.href = "{{ route('clearances.index') }}?" + searchParams.toString();
            });
        });
    </script>
    @endsection
</x-officer-app-layout>
