<x-officer-app-layout>

    <div class="flex justify-end mb-4">
        <a href="{{ route('students.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Students</a>
    </div>
    <div class="flex justify-end mb-4">
        <a href="{{ route('fees.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Finances</a>
    </div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Officer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>



</x-officer-app-layout>
