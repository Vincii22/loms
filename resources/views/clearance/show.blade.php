<x-app-layout>
    @section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Clearance Details</h1>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><strong>ID:</strong> {{ $clearance->user_id }}</p>
            <p><strong>Status:</strong> {{ $clearance->status }}</p>
            <!-- Add more fields if needed -->
        </div>

        <a href="{{ route('clearances.index') }}" class="mt-4 text-blue-500">Back to Status</a>
    </div>
    @endsection
</x-app-layout>
