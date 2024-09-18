<x-admin-app-layout>

    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
            {{ __('Admin') }} /
            <a href="" class="font-semibold text-indigo-600 uppercase">Admin Lists</a>
        </a>
    </x-slot>
        <div class="container mx-auto">
            <div class="flex justify-end mb-4">
                <a href="{{ route('admins.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 mb-4 inline-block">Create Admin</a>
            </div>

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4 relative">
                    {{ session('success') }}
                    <button class="absolute top-2 right-2 text-white" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            <div class="overflow-x-auto bg-white shadow mb-4 p-4 rounded-[10px]">
                <table id="userTable" class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[10px]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($admins as $admin)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $admin->name }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $admin->email }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ ucfirst($admin->status) }}</td>
                                <td class="px-4 py-4 whitespace-nowrap flex space-x-2">
                                    <a href="{{ route('admins.edit', $admin->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white  font-bold py-2 px-5 rounded-xl transition-all duration-150">Edit</a>
                                    <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-[#C43E3E] hover:bg-[#5C0E0F] text-white font-bold py-2 px-4 rounded-xl transition-all duration-150">Delete</button>
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
