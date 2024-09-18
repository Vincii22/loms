<x-officer-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
            {{ __('Officer') }} /
            <a href="{{ route('reports.sanction_statistics') }}" class="text-indigo-600 uppercase">Sanction Statistics</a>
        </a>
    </x-slot>

    <div class="container mx-auto">
        <!-- Filter Form -->
        <form id="filterForm" method="GET" action="{{ route('reports.sanction_statistics') }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Semester Filter -->
                <div class="w-full">
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester" id="semester" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $id => $name)
                            <option value="{{ $id }}" {{ request('semester') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- School Year Filter -->
                <div class="w-full">
                    <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <select name="school_year" id="school_year" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All School Years</option>
                        @foreach($schoolYears as $year)
                            <option value="{{ $year }}" {{ request('school_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sanction Type Filter -->
                <div class="w-full">
                    <label for="filter_type" class="block text-sm font-medium text-gray-700">Sanction Type</label>
                    <select name="filter_type" id="filter_type" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        @foreach($sanctionTypes as $type)
                            <option value="{{ $type }}" {{ request('filter_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full">
                    <label for="resolved" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="resolved" id="resolved" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="resolved" {{ request('resolved') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="not resolved" {{ request('resolved') == 'not resolved' ? 'selected' : '' }}>Not Resolved</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Sanction Statistics Chart -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-xl font-bold mb-4">Sanction Statistics</h2>

            <!-- Status Distribution Chart -->
            <div id="sanctionStatusChart" class="w-full">
                <canvas id="sanctionStatusChartCanvas"></canvas>
            </div>
        </div>
    </div>
    @endsection

    <script>
        // Chart.js script for Sanction Status Distribution
        const ctx = document.getElementById('sanctionStatusChartCanvas').getContext('2d');
        const sanctionStatusChart = new Chart(ctx, {
            type: 'bar', // Example chart type
            data: {
                labels: {!! json_encode($statusLabels) !!}, // Data passed from the controller
                datasets: [{
                    label: 'Sanction Status',
                    data: {!! json_encode($statusData) !!},
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)', // Resolved
                        'rgba(255, 99, 132, 0.2)'  // Not Resolved
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-officer-app-layout>
