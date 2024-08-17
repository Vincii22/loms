<x-officer-app-layout>

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Edit Fee</h1>

        <form action="{{ route('fees.update', $fee->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $fee->name) }}" class="form-input mt-1 block w-full" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="default_amount" class="block text-sm font-medium text-gray-700">Default Amount</label>
                <input type="number" id="default_amount" name="default_amount" value="{{ old('default_amount', $fee->default_amount) }}" class="form-input mt-1 block w-full" required>
                @error('default_amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Fee</button>
        </form>
    </div>
</x-officer-app-layout>
