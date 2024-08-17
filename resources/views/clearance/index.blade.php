<x-app-layout>
    @section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Clearance Status</h1>

        @if(session('success'))
            <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($clearance)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p><strong>Status:</strong> {{ $clearance->status }}</p>
                <!-- Add more fields if needed -->
            </div>
        @else
            <p>No clearance record found for your account.</p>
        @endif

        <!-- Add functionality if needed to update status -->
    </div>
    @endsection
</x-app-layout>
