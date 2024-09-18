<x-admin-app-layout>

@section('content')
<x-slot name="header">
    <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
        {{ __('Admin') }} /
        <a href="" class="font-semibold text-indigo-600 uppercase">Student Lists</a>
    </a>
</x-slot>

<div class="container mx-auto p-4">

    <div class="flex justify-end mb-4">
        <a href="{{ route('astudents.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create New Student</a>
    </div>
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 relative">
            {{ session('success') }}
            <button class="absolute top-2 right-2 text-white" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    
    <div class="overflow-x-auto bg-white shadow mb-4 p-4 rounded-[10px]">
        <table id="userTable" class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">School ID</th>
                    <th class="px-4 py-2 border-b">Student Name</th>
                    <th class="px-4 py-2 border-b">Organization</th>
                    <th class="px-4 py-2 border-b">Course</th>
                    <th class="px-4 py-2 border-b">Year</th>
                    <th class="px-4 py-2 border-b">Status</th> <!-- New column for status -->
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b text-center">{{ $user->school_id }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->organization ? $user->organization->name : 'N/A' }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->course ? $user->course->name : 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-center">{{ $user->year ? $user->year->name : 'N/A' }}</td>
                        <td class="px-4 py-2 border-b text-center">{{ ucfirst($user->status) }}</td> <!-- Show status -->
                        <td class="px-4 py-2 border-b text-center">
                            <a href="{{ route('astudents.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-4 rounded-xl transition-all duration-150">Edit</a> |
                            <form action="{{ route('astudents.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#C43E3E] hover:bg-[#5C0E0F] text-white font-bold py-1 px-4 rounded-xl transition-all duration-150">Delete</button>
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
