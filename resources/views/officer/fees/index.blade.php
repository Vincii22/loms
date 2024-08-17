<x-officer-app-layout>

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <div class="flex justify-end mb-4">
            <a href="{{ route('fees.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Fee</a>
        </div>
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Fee Management</h1>
        <ul>
            @foreach ($fees as $fee)
                <li class="flex items-center justify-between py-2">
                    <a href="{{ route('fees.show', $fee->id) }}" class="text-[#5C0E0F] hover:text-[#470A0B]">
                        {{ $fee->name }}
                    </a>
                    <div class="flex space-x-2">
                        <!-- Edit Button -->
                        <a href="{{ route('fees.edit', $fee->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <!-- Delete Button -->
                        <form action="{{ route('fees.destroy', $fee->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this fee?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-officer-app-layout>
