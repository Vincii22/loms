<x-admin-app-layout>

    @section('content')

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Pending Registrations</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left font-semibold text-gray-700">Name</th>
                        <th class="py-3 px-6 text-left font-semibold text-gray-700">Email</th>
                        <th class="py-3 px-6 text-left font-semibold text-gray-700">Type</th>
                        <th class="py-3 px-6 text-left font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through pending users -->
                    @foreach($pendingUsers as $user)
                        <tr class="border-t">
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6">User</td>
                            <td class="py-3 px-6">
                                <div class="flex space-x-2">
                                    <!-- Update action to approve user -->
                                    <form action="{{ route('admin.approveUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded">Approve</button>
                                    </form>
                                    <!-- Update action to reject user -->
                                    <form action="{{ route('admin.rejectUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4 rounded">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Loop through pending officers -->
                    @foreach($pendingOfficers as $officer)
                        <tr class="border-t">
                            <td class="py-3 px-6">{{ $officer->name }}</td>
                            <td class="py-3 px-6">{{ $officer->email }}</td>
                            <td class="py-3 px-6">Officer</td>
                            <td class="py-3 px-6">
                                <div class="flex space-x-2">
                                    <!-- Update action to approve officer -->
                                    <form action="{{ route('admin.approveOfficer', $officer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded">Approve</button>
                                    </form>
                                    <!-- Update action to reject officer -->
                                    <form action="{{ route('admin.rejectOfficer', $officer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4 rounded">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $pendingUsers->links() }}
        </div>

        <!-- Confirmation Dialog -->
        <div id="confirmation-dialog" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg">
                <p>Are you sure you want to perform this action?</p>
                <div class="mt-4 flex justify-end space-x-2">
                    <button id="confirm-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Yes</button>
                    <button id="cancel-button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">No</button>
                </div>
            </div>
        </div>
    </div>

    @endsection

</x-admin-app-layout>
