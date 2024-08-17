<x-admin-app-layout>

    @section('content')
    <div class="container mx-auto p-6">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Add New Student</h2>

            <!-- Make sure to include enctype="multipart/form-data" to handle file uploads -->
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
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

                <!-- Organization -->
                <div class="mt-4">
                    <label for="organization_id" class="block text-sm font-medium text-gray-700">Organization</label>
                    <select name="organization_id" id="organization_id" class="block mt-1 w-full border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Select Organization</option>
                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Course -->
                <div class="mt-4">
                    <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                    <select name="course_id" id="course_id" class="block mt-1 w-full border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Select Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year -->
                <div class="mt-4">
                    <label for="year_id" class="block text-sm font-medium text-gray-700">Year Level</label>
                    <select name="year_id" id="year_id" class="block mt-1 w-full border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Select Year</option>
                        @foreach($years as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach
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

                <!-- Image -->
                <div class="mt-4">
                    <x-input-label for="image" :value="__('Image')" />
                    <input id="image" class="block mt-1 w-full" type="file" name="image" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <!-- Barcode Image -->
                <div class="mt-4">
                    <x-input-label for="barcode_image" :value="__('Barcode Image')" />
                    <input id="barcode_image" class="block mt-1 w-full" type="file" name="barcode_image" />
                    <x-input-error :messages="$errors->get('barcode_image')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <button
                        type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm focus:ring-indigo-500"
                    >
                        Save
                    </button>
                    <a
                        href="{{ route('students.index') }}"
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
