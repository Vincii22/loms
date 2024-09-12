<x-admin-app-layout>

    @section('content')
        <h1>Admins</h1>
        <a href="{{ route('admins.create') }}" class="btn btn-primary">Create Admin</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th> <!-- Add status header -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ ucfirst($admin->status) }}</td> <!-- Display status -->
                        <td>
                            <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
    </x-admin-app-layout>
