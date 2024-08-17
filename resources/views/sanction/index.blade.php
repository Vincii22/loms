@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Sanctions</h1>

    @if($sanctions->isEmpty())
        <p class="text-gray-600">No sanctions found.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-md">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Type</th>
                        <th class="px-6 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Description</th>
                        <th class="px-6 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Fine Amount</th>
                        <th class="px-6 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Required Action</th>
                        <th class="px-6 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Status</th>
                        <th class="px-6 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sanctions as $sanction)
                        <tr class="border-b border-gray-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $sanction->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $sanction->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $sanction->fine_amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $sanction->required_action }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sanction->resolved ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $sanction->resolved ? 'Resolved' : 'Unresolved' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('sanction.show', $sanction->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
