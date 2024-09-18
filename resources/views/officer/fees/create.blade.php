<x-officer-app-layout>

    @section('content')
        <div class="container mx-auto py-3">
            <x-slot name="header">
                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                    {{ __('Officer') }} /
                    <a href="{{ route('fees.index') }}" class="text-black hover:underline">FINANCE /</a>
                    <a href="{{ route('finances.index') }}" class="text-indigo-600 uppercase">create new fee</a>
                </h2>
            </x-slot>

            <div class="">
                <div class="flex justify-between">
                    <div class="w-full pr-5 bg-white rounded-lg shadow-md p-6 mr-5 h-auto">
                        <form action="{{ route('fees.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Fee Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="default_amount" class="block text-sm font-medium text-gray-700">Default Amount</label>
                                <input type="number" name="default_amount" id="default_amount" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50" required>
                                @error('default_amount')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                                <select id="semester_id" name="semester_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50">
                                    <option value="">Select Semester</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                    @endforeach
                                </select>
                                @error('semester_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                                <input type="text" name="school_year" id="school_year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50">
                                @error('school_year')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center justify-center">
                                <button type="submit" class="bg-[maroon] hover:bg-[maroon] text-white font-bold py-2 px-4 rounded w-1/4 transition duration-300 ease-in-out">Create Fee</button>
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
        </div>
    </x-officer-app-layout>
