<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto mt-4 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Edit Finance Entry</h1>

        <form action="{{ route('finances.update', $finance->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="officer" class="block text-sm font-medium text-gray-700">Officer</label>
                <input type="text" id="officer" value="{{ $officer->name }}" readonly class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Student</label>
                <select name="user_id" id="user_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $finance->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="fee_id" class="block text-sm font-medium text-gray-700">Fee Name</label>
                <input type="text" id="fee_name" value="{{ $finance->fee->name }}" readonly class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <input type="hidden" name="fee_id" id="fee_id" value="{{ $finance->fee_id }}">
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="text" id="amount" value="{{ $finance->default_amount }}" readonly class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="Paid" {{ $finance->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Not Paid" {{ $finance->status == 'Not Paid' ? 'selected' : '' }}>Not Paid</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
        </form>
    </div>
    @endsection
</x-officer-app-layout>
