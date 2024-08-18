<x-officer-app-layout>

    @section('content')
        <div class="max-w-7xl mx-auto p-6 bg-white shadow-lg rounded-lg">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Edit Fee</h1>

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

                <button type="submit" class="bg-[#5C0
