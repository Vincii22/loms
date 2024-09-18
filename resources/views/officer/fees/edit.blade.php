<x-officer-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
            {{ __('Officer') }} / 
            <a class="font-semibold text-gray-800 leading-tight hover:underline" href="{{ route('fees.index') }}">FEE MANAGEMENT /</a>
            <a href="" class="font-semibold text-indigo-600 uppercase">Edit FEE</a>
        </a>
    </x-slot>
    <div class="">
        <div class="flex justify-between">
            <div class="w-full pr-5 bg-white rounded-lg shadow-md p-6 mr-5 h-auto">
            <form action="{{ route('fees.update', $fee->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Fee Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $fee->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="default_amount" class="block text-sm font-medium text-gray-700">Default Amount</label>
                    <input type="number" id="default_amount" name="default_amount" value="{{ old('default_amount', $fee->default_amount) }}" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50" required>
                    @error('default_amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select id="semester_id" name="semester_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50">
                        <option value="">Select Semester</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ $fee->semester_id == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                        @endforeach
                    </select>
                    @error('semester_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <input type="text" id="school_year" name="school_year" value="{{ old('school_year', $fee->school_year) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#5C0E0F] focus:ring focus:ring-[#5C0E0F] focus:ring-opacity-50">
                    @error('school_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center items-center text-center w-full">
                    <button type="submit" class="bg-[maroon] w-1/4 text-white px-4 py-2 rounded hover:bg-[#850104]">Update Attendance</button>
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
    @endsection
</x-officer-app-layout>
