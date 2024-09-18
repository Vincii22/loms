<x-admin-app-layout>
    @section('content')
    <x-slot name="header">
            <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
                {{ __('Admin') }} / 
                <a class="font-semibold text-gray-800 leading-tight hover:underline" href="{{ route('officers.index') }}">Officer Lists /</a>
                <a href="" class="font-semibold text-indigo-600 uppercase">Edit Officer</a>
            </a>
        </x-slot>

        <div class="">
            <div class="flex justify-between">
                <div class="w-full pr-5 bg-white rounded-lg shadow-md p-6 mr-5 h-auto">
                    <form action="{{ route('officers.update', $officer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex gap-4 mb-4">
                            <div class="w-full">
                                <x-input-label class="block text-sm font-medium !text-gray-700" for="name" :value="__('Officer Name')" />
                                <x-text-input id="name" class="form-control mt-1 block w-full !text-black !bg-white border-gray-300 rounded-md shadow-sm" type="text" name="name" :value="old('name', $officer->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="w-full">
                                <x-input-label class="block text-sm font-medium !text-gray-700" for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control mt-1 block w-full !text-black !bg-white border-gray-300 rounded-md shadow-sm" type="email" name="email" :value="old('email', $officer->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex gap-4 mb-4">
                            <div class="w-full">
                                <x-input-label class="block text-sm font-medium !text-gray-700" for="role" :value="__('Role')" />
                                <select id="role" name="role_id" class="form-control mt-1 block w-full !text-black !bg-white border-gray-300 rounded-md shadow-sm" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $officer->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                            </div>

                            <div class="w-full">
                                <x-input-label class="block text-sm font-medium !text-gray-700" for="status" :value="__('Status')" />
                                <select name="status" id="status" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="active" {{ $officer->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $officer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label class="block text-sm font-medium !text-gray-700" for="password" :value="__('Password')" />
                            <x-text-input id="password" class="form-control mt-1 block w-full !text-black !bg-white border-gray-300 rounded-md shadow-sm" type="password" name="password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label class="block text-sm font-medium !text-gray-700" for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="form-control mt-1 block w-full !text-black !bg-white border-gray-300 rounded-md shadow-sm" type="password" name="password_confirmation" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label class="block text-sm font-medium !text-gray-700" for="image" :value="__('Profile Image')" />
                            @if ($officer->image)
                                <img src="{{ asset('storage/' . $officer->image) }}" alt="Officer Image" class="mb-2 w-24 h-24 object-cover">
                            @endif
                            <input id="image" class="form-control mt-1 block w-full !text-black !bg-white border-gray-300 rounded-md shadow-sm" type="file" name="image" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-center mt-4 text-center">
                            <x-primary-button class="ml-4 !bg-[maroon] hover:!bg-[#b90000] !text-white font-bold py-2 px-16 rounded transition duration-300 ease-in-out">
                                {{ __('Update') }}
                            </x-primary-button>
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
