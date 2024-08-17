<table class="min-w-full bg-white border border-gray-200">
    <thead>
        <!-- Table headers -->
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
                <td class="px-4 py-2 border-b text-center">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Student Image" class="w-16 h-16 object-cover">
                    @else
                        N/A
                    @endif
                </td>
                <td class="px-4 py-2 border-b text-center">
                    <a href="{{ route('students.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a> |
                    <form action="{{ route('students.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
