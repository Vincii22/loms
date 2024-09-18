<x-officer-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
            {{ __('Officer') }} /
            <a href="{{ route('reports.attendance_statistics') }}" class="text-indigo-600 uppercase">Statical REPORT</a>
        </a>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('reports.attendance_statistics') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="activity_id" class="block text-sm font-medium text-gray-700">Activity</label>
                    <select id="activity_id" name="activity_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Activity</option>
                        @foreach($activities as $id => $name)
                            <option value="{{ $id }}" {{ request('activity_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <select id="semester" name="semester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Semester</option>
                        @foreach($semesters as $id => $name)
                            <option value="{{ $id }}" {{ request('semester') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="school_year" class="block text-sm font-medium text-gray-700">School Year</label>
                    <input type="text" id="school_year" name="school_year" value="{{ request('school_year') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            </div>

            <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Filter
            </button>
        </form>

        <!-- Check if data is available -->
        @if(isset($attendanceLabels) && count($attendanceLabels) > 0)
            <!-- Attendance Count Chart -->
            <div class="mb-6" style="position: relative; height: 400px; width: 100%;">
                <canvas id="attendanceChart" style="width: 100%; height: 100%;"></canvas>
            </div>

            <!-- Activity Distribution Chart -->
            <div class="mb-6" style="position: relative; height: 400px; width: 100%;">
                <canvas id="activityDistributionChart" style="width: 100%; height: 100%;"></canvas>
            </div>

            <!-- User Attendance Table -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Attendance by User</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Attendance Count
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($userLabels as $index => $userLabel)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $userLabel }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $userData[$index] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <p>No data available. Please select filters and submit to view statistics.</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctxAttendance = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctxAttendance, {
                type: 'line',
                data: {
                    labels: @json($attendanceLabels),
                    datasets: [{
                        label: 'Overall Attendance Trend',
                        data: @json($attendanceData),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Activities'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Attendance Count'
                            }
                        }
                    }
                }
            });

            var ctxActivity = document.getElementById('activityDistributionChart').getContext('2d');
            new Chart(ctxActivity, {
                type: 'bar',
                data: {
                    labels: @json($activityLabels),
                    datasets: [{
                        label: 'Activity Distribution',
                        data: @json($activityData),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Activities'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Count'
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endsection
</x-officer-app-layout>
