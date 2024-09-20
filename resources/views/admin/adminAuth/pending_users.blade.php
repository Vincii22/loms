<x-admin-app-layout>
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
            {{ __('Admin') }} /
            <a href="" class="font-semibold text-indigo-600 uppercase">Pending Registrations</a>
        </a>
    </x-slot>

    @section('content')

    <div class="container mx-auto">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow mb-4 p-4 rounded-[10px]">
            <table id="userTable" class="min-w-full bg-white border border-gray-200">
                <thead class="bg-white border-b border-gray-300">
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border-b">Name</th>
                        <th class="px-4 py-2 border-b">Email</th>
                        <th class="px-4 py-2 border-b">Type</th>
                        <th class="px-4 py-2 border-b w-[10px]">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through pending users -->
                    @foreach($pendingUsers as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                            <td class="px-4 py-2 border-b">User</td>
                            <td class="py-4 px-2">
                                <div class="flex space-x-2">
                                    <form action="{{ route('admin.approveUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded-xl transition-all duration-150">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.rejectUser', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-[#C43E3E] hover:bg-[#5C0E0F] text-white font-bold py-1 px-4 rounded-xl transition-all duration-150">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <!-- Loop through pending officers -->
                    @foreach($pendingOfficers as $officer)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $officer->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $officer->email }}</td>
                            <td class="px-4 py-2 border-b">Officer</td>
                            <td class="py-4 px-2">
                                <div class="flex space-x-2">
                                    <form action="{{ route('admin.approveOfficer', $officer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded-xl transition-all duration-150">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.rejectOfficer', $officer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-[#C43E3E] hover:bg-[#5C0E0F] text-white font-bold py-1 px-4 rounded-xl transition-all duration-150">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6">
                {{ $pendingUsers->links() }}
            </div>
        </div>

        <!-- Pagination -->
        

        <!-- Confirmation Dialog -->
        <div id="confirmation-dialog" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg">
                <p class="text-gray-800">Are you sure you want to perform this action?</p>
                <div class="mt-4 flex justify-end space-x-2">
                    <button id="confirm-button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Yes</button>
                    <button id="cancel-button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">No</button>
                </div>
            </div>
        </div>
    </div>




    <style>
    .dataTables_paginate{
        display: none !important;
    }

    .dataTables_info{
        display: none !important;

    }
</style>
    @endsection
</x-admin-app-layout>