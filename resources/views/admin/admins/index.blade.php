<x-admin-app-layout>

    @section('content')
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Admins</h1>
            <a href="{{ route('admins.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 mb-4 inline-block">Create Admin</a>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4 relative">
                    {{ session('success') }}
                    <button class="absolute top-2 right-2 text-white" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($admins as $admin)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $admin->name }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $admin->email }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ ucfirst($admin->status) }}</td>
                                <td class="px-4 py-4 whitespace-nowrap flex space-x-2">
                                    <a href="{{ route('admins.edit', $admin->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-xs">Edit</a>
                                    <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

</x-admin-app-layout>
