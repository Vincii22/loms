<x-officer-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
            {{ __('Officer') }} /
            <a href="{{ route('reports.clearance_statistics') }}" class="text-indigo-600 uppercase">Clearance Statistics</a>
        </a>
    </x-slot>

    <div class="container mx-auto">
        <form method="GET" action="{{ route('reports.clearance_statistics') }}" id="filters-form">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-3 mb-5 px-4">
                <!-- Filter Semesters -->
                <div class="w-full">
                    <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select name="semester_id" id="semester_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter School Years -->
                <div class="w-full">
                    <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <select name="school_year" id="school_year" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All School Years</option>
                        @foreach($schoolYears as $year)
                            <option value="{{ $year }}" {{ request('school_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <!-- Clearance Statistics -->
        <div class="overflow-x-auto bg-white p-5 rounded shadow-sm">
            @if(isset($statusLabels) && count($statusLabels) > 0)
                <!-- Graphs Container with Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Status Distribution Chart -->
                    <div class="relative h-64 w-full">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>

                    <!-- Clearances by Semester -->
                    <div class="relative h-64 w-full">
                        <canvas id="clearancesBySemesterChart"></canvas>
                    </div>

                    <!-- Clearances by School Year -->
                    <div class="relative h-64 w-full">
                        <canvas id="clearancesByYearChart"></canvas>
                    </div>

                    <!-- Top Users by Clearances -->
                    <div class="relative h-64 w-full">
                        <canvas id="topUsersChart"></canvas>
                    </div>
                </div>

                <!-- User Clearance Table -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4">Clearances by User</h2>
                    <table id="userTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($userClearances as $userClearance)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $userClearance['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $userClearance['status'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No data available. Please select filters and submit to view statistics.</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Helper function to generate random colors for charts
            function generateRandomColors(length) {
                const colors = [];
                for (let i = 0; i < length; i++) {
                    const randomColor = `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`;
                    colors.push(randomColor);
                }
                return colors;
            }

            // Pie Chart for Status Distribution
            var ctxStatus = document.getElementById('statusDistributionChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'pie',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        label: 'Status Distribution',
                        data: @json($statusData),
                        backgroundColor: generateRandomColors(@json($statusLabels).length),
                        borderColor: generateRandomColors(@json($statusLabels).length),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Bar Chart for Clearances by Semester
            var ctxSemester = document.getElementById('clearancesBySemesterChart').getContext('2d');
            new Chart(ctxSemester, {
                type: 'bar',
                data: {
                    labels: @json($semesters->pluck('name')),
                    datasets: [{
                        label: 'Clearances by Semester',
                        data: @json($semesterData),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Line Chart for Clearances by School Year
            var ctxYear = document.getElementById('clearancesByYearChart').getContext('2d');
            new Chart(ctxYear, {
                type: 'line',
                data: {
                    labels: @json($schoolYears),
                    datasets: [{
                        label: 'Clearances by School Year',
                        data: @json($yearData),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Bar Chart for Top Users by Clearances
            var ctxTopUsers = document.getElementById('topUsersChart').getContext('2d');
            new Chart(ctxTopUsers, {
                type: 'bar',
                data: {
                    labels: @json($topUsers->pluck('name')),
                    datasets: [{
                        label: 'Top 5 Users by Clearances',
                        data: @json($topUsersData),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Automatic form submission when filter changes
            document.querySelectorAll('#filters-form select').forEach(select => {
                select.addEventListener('change', function() {
                    document.getElementById('filters-form').submit();
                });
            });
        });
    </script>
    @endsection
</x-officer-app-layout>
