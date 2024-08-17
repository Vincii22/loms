<x-officer-app-layout>

@section('content')
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create Finance Entry</h1>

        <form action="{{ route('finances.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Student</label>
                <select name="user_id" id="user_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option></option> <!-- Allow clear -->
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="fee_id" class="block text-sm font-medium text-gray-700">Fee Name</label>
                <select name="fee_id" id="fee_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option></option> <!-- Allow clear -->
                    @foreach ($fees as $fee)
                    <option value="{{ $fee->id }}" data-default-amount="{{ $fee->default_amount }}">{{ $fee->name }}</option>
                @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="default_amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" step="0.01" name="default_amount" id="default_amount" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
            </div>

            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="Paid">Paid</option>
                    <option value="Not Paid">Not Paid</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Create
            </button>
        </form>

    </div>

    <script>
  document.addEventListener('DOMContentLoaded', function() {
        var feeSelect = document.getElementById('fee_id');
        var defaultAmountInput = document.getElementById('default_amount');

        // Initialize Select2 for the fee_id dropdown
        if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
            $(feeSelect).select2({
                placeholder: 'Select a fee',
                allowClear: true,
                width: '100%'
            });
        }

        // Event handler for when the selected fee changes
        feeSelect.addEventListener('change', function() {
            var selectedOption = feeSelect.options[feeSelect.selectedIndex];
            var defaultAmount = selectedOption.getAttribute('data-default-amount');
            defaultAmountInput.value = defaultAmount || ''; // Set to empty if no amount is found
        });

        // Trigger change event on page load to ensure the amount is set if a fee is pre-selected
        var selectedOption = feeSelect.options[feeSelect.selectedIndex];
        if (selectedOption) {
            var defaultAmount = selectedOption.getAttribute('data-default-amount');
            defaultAmountInput.value = defaultAmount || ''; // Set to empty if no amount is found
        }
    });
        </script>
</x-officer-app-layout>
