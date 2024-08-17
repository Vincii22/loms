<x-officer-app-layout>

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Create New Fee</h1>

        <form action="{{ route('fees.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Fee Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="default_amount" class="block text-sm font-medium text-gray-700">Default Amount</label>
                <input type="number" name="default_amount" id="default_amount" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50" required>
                @error('default_amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-[#5C0E0F] text-white px-4 py-2 rounded-md hover:bg-[#470A0B]">Create Fee</button>
        </form>
    </div>
</x-officer-app-layout>
