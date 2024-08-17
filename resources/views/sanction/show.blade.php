@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Sanction Details</h1>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Type:</h2>
            <p class="text-gray-600">{{ $sanction->type }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Description:</h2>
            <p class="text-gray-600">{{ $sanction->description }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Fine Amount:</h2>
            <p class="text-gray-600">{{ $sanction->fine_amount }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Required Action:</h2>
            <p class="text-gray-600">{{ $sanction->required_action }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Status:</h2>
            <p class="text-gray-600">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sanction->resolved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $sanction->resolved ? 'Resolved' : 'Unresolved' }}
                </span>
            </p>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('sanctions.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Back to Sanctions List</a>
        </div>
    </div>
</div>
@endsection
