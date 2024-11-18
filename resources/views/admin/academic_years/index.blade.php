<x-admin-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('admin.dashboard') }}">
            {{ __('Admin') }} /
            <a href="" class="font-semibold text-indigo-600 uppercase">Academic Lists</a>
        </a>
    </x-slot>

    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Academic Years</h1>
            <a href="{{ route('academic_years.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-indigo-700">
                Add Academic Year
            </a>
        </div>

        <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            School Year
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Semester
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Default
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($academicYears as $year)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $year->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $year->school_year }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $year->semester->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $year->is_default ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $year->is_default ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('academic_years.edit', $year) }}"
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('academic_years.destroy', $year) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 ml-2">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endsection
</x-admin-app-layout>
