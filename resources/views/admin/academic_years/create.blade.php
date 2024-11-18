<x-admin-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
            {{ __('Admin') }} /
            <a href="" class="font-semibold text-indigo-600 uppercase">{{ isset($academicYear) ? 'Edit' : 'Add' }} Academic Year</a>
        </a>
    </x-slot>

    <div class="container mx-auto p-6">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                {{ isset($academicYear) ? 'Edit Academic Year' : 'Add Academic Year' }}
            </h1>

            <form action="{{ isset($academicYear) ? route('academic_years.update', $academicYear) : route('academic_years.store') }}"
                  method="POST"
                  class="space-y-6">
                @csrf
                @if (isset($academicYear))
                    @method('PUT')
                @endif

                <!-- School Year -->
                <div>
                    <label for="school_year" class="block text-sm font-medium text-gray-700">
                        School Year
                    </label>
                    <input type="text"
                           id="school_year"
                           name="school_year"
                           value="{{ old('school_year', $academicYear->school_year ?? '') }}"
                           required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Semester -->
                <div>
                    <label for="semester_id" class="block text-sm font-medium text-gray-700">
                        Semester
                    </label>
                    <select id="semester_id"
                            name="semester_id"
                            required
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ isset($academicYear) && $academicYear->semester_id == $semester->id ? 'selected' : '' }}>
                                {{ $semester->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Set as Default -->
                <div class="flex items-center">
                    <input type="checkbox"
                           id="is_default"
                           name="is_default"
                           {{ isset($academicYear) && $academicYear->is_default ? 'checked' : '' }}
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="is_default" class="ml-2 block text-sm text-gray-900">
                        Set as Default
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="px-6 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ isset($academicYear) ? 'Update Academic Year' : 'Create Academic Year' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-admin-app-layout>
