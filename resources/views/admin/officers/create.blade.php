<x-admin-app-layout>

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Add New Officer</h2>

        <form action="{{ route('officers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="mt-4">
                <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role_id" id="role_id" class="block mt-1 w-full border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Image -->
            <div class="mt-4">
                <x-input-label for="image" :value="__('Image')" />
                <input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="status" :value="__('Status')" />
                <select name="status" id="status" class="block mt-1 w-full border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <button
                    type="submit"
                    class="bg-indigo-600 text-black px-4 py-2 rounded-md shadow-sm focus:ring-indigo-500"
                >
                    Save
                </button>
                <a
                    href="{{ route('officers.index') }}"
                    class="text-indigo-600 hover:text-indigo-900"
                >
                    Back to list
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
</x-admin-app-layout>
