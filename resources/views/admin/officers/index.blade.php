<x-admin-app-layout>

@section('content')

<div class="container mx-auto p-4">

    <div class="flex justify-end mb-4">
        <a href="{{ route('officers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create New Officer</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Officer Name</th>
                    <th class="px-4 py-2 border-b">Role</th>
                    <th class="px-4 py-2 border-b">Image</th> <!-- New column header for image -->
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($officers as $officer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b text-center">{{ $officer->id }}</td>
                        <td class="px-4 py-2 border-b">{{ $officer->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $officer->role ? $officer->role->name : 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-center">
                            @if($officer->image) <!-- Check if image exists -->
                                <img src="{{ asset('storage/' . $officer->image) }}" alt="Officer Image" class="w-16 h-16 object-cover">
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b text-center">
                            <a href="{{ route('officers.edit', $officer->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a> |
                            <form action="{{ route('officers.destroy', $officer->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-admin-app-layout>
