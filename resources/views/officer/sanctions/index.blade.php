<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto px-4 mt-4">
        <h1 class="text-2xl font-bold mb-4">Sanctions</h1>

        @if(session('success'))
            <div class="alert alert-success bg-green-500 text-white rounded-lg p-3 mb-4 flex items-center justify-between">
                {{ session('success') }}
                <button type="button" class="btn-close" aria-label="Close" onclick="this.parentElement.remove();">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('sanctions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">Add Sanction</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Student</th>
                        <th class="py-2 px-4 border-b">Type</th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <th class="py-2 px-4 border-b">Fine Amount</th>
                        <th class="py-2 px-4 border-b">Required Action</th>
                        <th class="py-2 px-4 border-b">Resolved</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sanctions as $sanction)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $sanction->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->student->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->type }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->description }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->fine_amount ? '' . number_format($sanction->fine_amount, 2) : 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->required_action ?: 'N/A' }}</td>
                        <td class="py-2 px-4 border-b">{{ $sanction->resolved ? 'Yes' : 'No' }}</td>
                        <td class="py-2 px-4 border-b flex space-x-2">
                            <a href="{{ route('sanctions.edit', $sanction->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition text-xs">Edit</a>
                            <form action="{{ route('sanctions.destroy', $sanction->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition text-xs" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-2 px-4 border-b text-center text-gray-500">No sanctions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection
    </x-officer-app-layout>
