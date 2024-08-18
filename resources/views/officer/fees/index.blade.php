<x-officer-app-layout>

    @section('content')
        <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
            <div class="flex justify-end mb-4">
                <a href="{{ route('fees.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Fee</a>
            </div>
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Fee Management</h1>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Default Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($fees as $fee)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $fee->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $fee->default_amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $fee->semester ? $fee->semester->name : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $fee->school_year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-officer-app-layout>
