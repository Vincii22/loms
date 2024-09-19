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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Semester Filter -->
                <div class="w-full">
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester" id="semester" class="block w-full" onchange="this.form.submit()">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $id => $name)
                            <option value="{{ $id }}" {{ request('semester') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- School Year Filter -->
                <div class="w-full">
                    <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <select name="school_year" id="school_year" class="block w-full" onchange="this.form.submit()">
                        <option value="">All School Years</option>
                        @foreach($schoolYears as $year)
                            <option value="{{ $year }}" {{ request('school_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full">
                    <label for="resolved" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="resolved" id="resolved" class="block w-full" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="resolved" {{ request('resolved') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="not resolved" {{ request('resolved') == 'not resolved' ? 'selected' : '' }}>Not Resolved</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Sanction Statistics Charts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Sanction Status Distribution Chart -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Sanction Status Distribution</h2>
                <canvas id="sanctionStatusChartCanvas"></canvas>
            </div>

            <!-- Total Fines by School Year Chart -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Total Fines by School Year</h2>
                <canvas id="totalFinesChartCanvas"></canvas>
            </div>

            <!-- Resolved vs Not Resolved by Year Chart -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Resolved vs Not Resolved by Year</h2>
                <canvas id="resolvedVsNotResolvedChartCanvas"></canvas>
            </div>

            <!-- Sanction Count by Semester Chart (Pie Chart) -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Sanction Count by Semester</h2>
                <canvas id="sanctionCountChartCanvas"></canvas>
            </div>

            <!-- Resolved vs Not Resolved Over Time (Line Chart) -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Resolved vs Not Resolved Over Time</h2>
                <canvas id="resolvedOverTimeChartCanvas"></canvas>
            </div>
        </div>

        <!-- Sanctions Table -->
        <div class="overflow-x-auto bg-white p-5 rounded shadow-sm mt-5">
            <table id="sanctionTable" class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">School Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fine Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sanctions as $sanction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sanction->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sanction->student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sanction->semester->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sanction->school_year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">P{{ number_format($sanction->fine_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sanction->resolved == 'resolved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($sanction->resolved) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No sanctions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6">
                {{ $sanctions->links() }}
            </div>
        </div>
    </div>

    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sanction Status Distribution Chart
            const ctx1 = document.getElementById('sanctionStatusChartCanvas').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($statusLabels) !!},
                    datasets: [{
                        label: 'Sanction Status',
                        data: {!! json_encode($statusData) !!},
                        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Total Fines by School Year Chart
            const ctx2 = document.getElementById('totalFinesChartCanvas').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: {!! json_encode($fineLabels) !!},
                    datasets: [{
                        label: 'Total Fines',
                        data: {!! json_encode($fineData) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Resolved vs Not Resolved by Year Chart
            const ctx3 = document.getElementById('resolvedVsNotResolvedChartCanvas').getContext('2d');
            new Chart(ctx3, {
                type: 'bar',
                data: {

                    labels: {!! json_encode($fineLabels) !!},
                    datasets: [
                        {
                            label: 'Resolved',
                            data: {!! json_encode($resolvedYearCounts) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        },
                        {
                            label: 'Not Resolved',
                            data: {!! json_encode($notResolvedYearCounts) !!},
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        }
                    ]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Sanction Count by Semester Chart (Pie Chart)
            const ctx4 = document.getElementById('sanctionCountChartCanvas').getContext('2d');
            const sanctionCounts = {!! json_encode($semesterCounts) !!};
            new Chart(ctx4, {
                type: 'pie',
                data: {
                    labels: Object.keys(sanctionCounts),
                    datasets: [{
                        label: 'Sanction Count by Semester',
                        data: Object.values(sanctionCounts),
                        backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)', 'rgba(255, 206, 86, 0.6)', 'rgba(54, 162, 235, 0.6)'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });

            // Resolved vs Not Resolved Over Time Chart (Line Chart)
            const ctx5 = document.getElementById('resolvedOverTimeChartCanvas').getContext('2d');
            const resolvedCounts = {!! json_encode($resolvedYearCounts) !!};
            const notResolvedCounts = {!! json_encode($notResolvedYearCounts) !!};
            new Chart(ctx5, {
                type: 'line',
                data: {
                    labels: {!! json_encode($fineLabels) !!},
                    datasets: [
                        {
                            label: 'Resolved',
                            data: resolvedCounts,
                            fill: false,
                            borderColor: 'rgba(75, 192, 192, 1)',
                        },
                        {
                            label: 'Not Resolved',
                            data: notResolvedCounts,
                            fill: false,
                            borderColor: 'rgba(255, 99, 132, 1)',
                        }
                    ]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
    @endsection
</x-officer-app-layout>
