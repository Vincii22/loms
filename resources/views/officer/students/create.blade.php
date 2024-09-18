<x-officer-app-layout>

@section('content')
<div class="container mx-auto py-3">
        <x-slot name="header">
            <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
                {{ __('Admin') }} / 
                <a class="font-semibold text-gray-800 leading-tight hover:underline" href="{{ route('students.index') }}">STUDENT LISTS /</a>
                <a href="" class="font-semibold text-indigo-600 uppercase">Create Student</a>
            </a>
        </x-slot>
            <div class="">
                <div class="flex justify-between">
                    <div class="w-full pr-5 bg-white rounded-lg shadow-md p-6 mr-5 h-auto">
                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf

                        <div class="flex gap-4">
                            <!-- Name -->
                            <div class="mt-4 w-full">
                                <x-input-label for="name" :value="__('Name')" />
                                <input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4 w-full">
                                <x-input-label for="email" :value="__('Email')" />
                                <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>


                        <!-- School ID -->
                        <div class="mt-4 w-full">
                            <x-input-label for="school_id" :value="__('School ID')" />
                            <input id="school_id" class="block mt-1 w-full" type="text" name="school_id" :value="old('school_id')" required autocomplete="school_id" />
                            <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
                        </div>

                        <div class="flex gap-4">
                            <!-- Organization -->
                            <div class="mt-4 w-full">
                                <label for="organization_id" class="block text-sm font-medium text-gray-700">Organization</label>
                                <select name="organization_id" id="organization_id" class="block mt-1 w-full border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Select Organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Course -->
                            <div class="mt-4 w-full">
                                <label for="course_id" class="block text-sm font-medium text-gray-700">Course</label>
                                <select name="course_id" id="course_id" class="block mt-1 w-full border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                                <!-- Year -->
                            <div class="mt-4 w-full">
                                <label for="year_id" class="block text-sm font-medium text-gray-700">Year Level</label>
                                <select name="year_id" id="year_id" class="block mt-1 w-full border-gray-300 shadow-sm rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Select Year</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div class="mt-4 my-5">
                            <x-input-label for="image" :value="__('Image')" />
                            <input id="image" class="block mt-1 w-full" type="file" name="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
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

</x-officer-app-layout>
