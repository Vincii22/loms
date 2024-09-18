<x-admin-app-layout>

    @section('content')
        <x-slot name="header">
            <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
                {{ __('Admin') }} / 
                <a class="font-semibold text-gray-800 leading-tight hover:underline" href="{{ route('admins.index') }}">Admin Lists /</a>
                <a href="" class="font-semibold text-indigo-600 uppercase">Edit Admin</a>
            </a>
        </x-slot>
        <div class="">
            <div class="flex justify-between">
                <div class="w-full pr-5 bg-white rounded-lg shadow-md p-6 mr-5 h-auto">
                    <form action="{{ route('admins.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex gap-4 mb-4">
                            <div class="w-full">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $admin->name }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $admin->email }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password (leave blank to keep current password)</label>
                            <input type="password" name="password" id="password" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <!-- Status dropdown -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="active" {{ $admin->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $admin->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-center mt-4 text-center">
                            <button type="submit" class="ml-4 !bg-[maroon] hover:!bg-[#b90000] !text-white font-bold py-2 px-16 rounded transition duration-300 ease-in-out">Update</button>
                        </div>

                    </form>
                </div>
                <div class="hidden relative md:flex md:w-1/4 bg-cover bg-no-repeat bg-center" style="background-image: url('{{ asset('images/a22bdfe2-9782-4e40-ac24-750136e7d7b9.jpeg') }}');">
                    <div class="bg-[#5c0e0f] bg-opacity-90 w-full h-full flex items-center justify-center text-white p-10">
                        <div class="text-center">
                            <div class="flex items-center justify-center">
                            <img src="{{ asset('images/licoes.png') }}" alt="" class="w-[300px]">
                            </div>
                            <h1 class="text-2xl font-bold mb-4">LEAGUE OF INTEGRATED COMPUTER AND ENGINEERING STUDENTS</h1>
                            <div class="w-full flex items-center justify-center">
                                <!-- <p class="text-sm leading-relaxed w-[400px]">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec neque tortor. Proin efficitur leo vel ex aliquam ullamcorper.</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    </x-admin-app-layout>
