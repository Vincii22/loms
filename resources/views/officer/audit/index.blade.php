<x-officer-app-layout>

    @section('content')
    <div class="container mx-auto py-2 ">
        <x-slot name="header">
            <a href="{{ route('officer.dashboard') }}" class="font-semibold text-lg text-gray-800 leading-tight" >
                {{ __('Officer') }} /
                <a href="{{ route('fees.index') }}" class="text-black hover:underline">FINANCE /</a>
                <a href="" class="text-indigo-600 uppercase">Manage audit</a>
            </a>
        </x-slot>
        <form id="fee-form" action="{{ route('audit.index') }}" method="GET" class="mb-6">
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="fee_id" class="block text-sm font-medium text-gray-700">Select Fee:</label>
                    <select name="fee_id" id="fee_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Select Fee --</option>
                        @foreach($fees as $fee)
                            <option value="{{ $fee->id }}" {{ $selectedFeeId == $fee->id ? 'selected' : '' }}>
                                {{ $fee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        @if($selectedFeeId)
            <!-- Fee Summary Card -->
            <div class=" p-6 rounded-lg shadow-md mb-6 flex justify-between" style="background: linear-gradient(to right, #c43e3e 20%, #5C0E0F);">
                <div class="">
                    <h2 class="text-xl font-semibold text-white mb-2">Summary for {{ $fees->find($selectedFeeId)->name }}</h2>
                    <p class="text-lg font-medium text-green-200">Fee Collected: <span class="font-bold text-green-100">₱{{ $feeCollected }}</span></p>
                    <p class="text-lg font-medium text-red-200">Fee Not Collected: <span class="font-bold text-red-100">₱{{ $feeNotCollected }}</span></p>
                    <p class="text-lg font-medium text-gray-200">Target Budget: <span class="font-bold text-gray-100">₱{{ $targetBudget }}.00</span></p>
                </div>
                <div>
                    <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="block h-[120px] w-auto fill-current">
                </div>
            </div>


            <!-- Table to display detailed information -->
            <div class="overflow-x-auto bg-white p-5 rounded shadow-sm">
                <table id="userTable" class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Default Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Officer Name</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($details as $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->user_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->default_amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detail->officer->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No details available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-700">Please select a fee to view the summary.</p>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const feeSelect = document.getElementById('fee_id');
            feeSelect.addEventListener('change', function() {
                document.getElementById('fee-form').submit();
            });
        });
    </script>
    @endsection
    </x-officer-app-layout>
