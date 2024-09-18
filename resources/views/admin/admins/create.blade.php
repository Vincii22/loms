<x-admin-app-layout>
    @section('content')
        <div class="container mx-auto py-3">
        <x-slot name="header">
            <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
                {{ __('Admin') }} / 
                <a class="font-semibold text-lg text-gray-800 leading-tight hover:underline" href="{{ route('admins.index') }}">ADMIN LISTS /</a>
                <a href="" class="font-semibold text-indigo-600 uppercase">Create Admin</a>
            </a>
        </x-slot>
            <div class="">

                <div class="flex justify-between">
                    <div class="w-full pr-5 bg-white rounded-lg shadow-md p-6 mr-5 h-auto">
                        <form action="{{ route('admins.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="flex gap-4">
                                <div class="form-group w-full">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                    <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-md focus:ring-[maroon]-500 focus:border-[maroon]-500 px-3 py-2" required>
                                    @error('name')
                                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group w-full">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-md focus:ring-[maroon]-500 focus:border-[maroon]-500 px-3 py-2" required>
                                    @error('email')
                                        <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-md focus:ring-[maroon]-500 focus:border-[maroon]-500 px-3 py-2" required>
                                @error('password')
                                    <span class="text-xs text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded-md focus:ring-[maroon]-500 focus:border-[maroon]-500 px-3 py-2" required>
                            </div>

                            <!-- Status dropdown -->
                            <div class="form-group">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full border border-gray-300 rounded-md focus:ring-[maroon]-500 focus:border-[maroon]-500 px-3 py-2" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="bg-[maroon] hover:bg-[maroon] text-white font-bold py-2 px-4 rounded w-full transition duration-300 ease-in-out">Create</button>
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
        </div>
    @endsection
</x-admin-app-layout>