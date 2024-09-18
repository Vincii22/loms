<x-admin-app-layout>

@section('content')
<x-slot name="header">
    <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
        {{ __('Admin') }} /
        <a href="" class="font-semibold text-indigo-600 uppercase">Officer Lists</a>
    </a>
</x-slot>
<div class="container mx-auto">

    <div class="flex justify-end mb-4">
        <a href="{{ route('officers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create New Officer</a>
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
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Officer Name</th>
                    <th class="px-4 py-2 border-b">Role</th>
                    <th class="px-4 py-2 border-b">Image</th>
                    <th class="px-4 py-2 border-b">Status</th>
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
                        <td class="px-4 py-2 border-b text-center">{{ $officer->status }}</td>
                        <td class="px-4 py-2 border-b text-center">
                            <a href="{{ route('officers.edit', $officer->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white  font-bold py-2 px-5 rounded-xl transition-all duration-150">Edit</a> 
                            <form action="{{ route('officers.destroy', $officer->id) }}" method="POST" class="inline">
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
