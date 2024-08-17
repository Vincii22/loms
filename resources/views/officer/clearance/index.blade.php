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
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status</label>
            <select id="status" name="status" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">All Statuses</option>
                <option value="eligible" {{ request('status') === 'eligible' ? 'selected' : '' }}>Eligible</option>
                <option value="not eligible" {{ request('status') === 'not eligible' ? 'selected' : '' }}>Not Eligible</option>
                <option value="cleared" {{ request('status') === 'cleared' ? 'selected' : '' }}>Cleared</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left text-gray-600">ID</th>
                        <th class="py-2 px-4 text-left text-gray-600">Name</th>
                        <th class="py-2 px-4 text-left text-gray-600">Status</th>
                        <th class="py-2 px-4 text-left text-gray-600">Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clearances as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->id }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                {{ $user->clearance ? $user->clearance->status : 'Not Set' }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <form action="{{ route('clearances.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="form-select border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="eligible" {{ $user->clearance && $user->clearance->status === 'eligible' ? 'selected' : '' }}>Eligible</option>
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
        document.getElementById('status').addEventListener('change', function() {
            var status = this.value;
            window.location.href = "{{ route('clearances.index') }}?status=" + status;
        });
    </script>
    @endsection
</x-officer-app-layout>
