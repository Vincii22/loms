<x-officer-app-layout>
    <x-slot name="header">
        <div>
            <!-- Title -->
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Officer Dashboard') }}
            </h2>

            <!-- Filter Form -->
            <div class="mt-4 flex space-x-4">
                <form method="GET" action="{{ route('officer.dashboard') }}" class="flex items-center space-x-4">
                    <!-- Semester Dropdown -->
                    <select name="semester" class="bg-gray-100 border border-gray-300 rounded-md py-2 px-4">
                        <option value="" disabled selected>Select Semester</option>
                        <!-- Replace these options with your actual semesters -->
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>

                    <!-- Year Dropdown -->
                    <select name="year" class="bg-gray-100 border border-gray-300 rounded-md py-2 px-4">
                        <option value="" disabled selected>Select Year</option>
                        <!-- Replace these options with your actual years -->
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>

                    <!-- Submit Button -->
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                        Filter
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Links for Activities and Fees -->
                    <div class="flex justify-between mb-6">
                        <!-- Link to Activities -->
                        <a href="{{ route('activities.index') }}" class="text-blue-500 hover:text-blue-700 text-lg font-semibold">
                            View All Activities
                        </a>

                        <!-- Link to Fees -->
                        <a href="{{ route('fees.index') }}" class="text-blue-500 hover:text-blue-700 text-lg font-semibold">
                            View All Fees
                        </a>
                    </div>

                    <!-- Container for Total Activities, Total Fees, and Total Students -->
                    <div class="border border-gray-300 rounded-md p-4 mb-6">
                        <div class="flex gap-6 mb-6">
                              <!-- Total Students -->
                              <div class="flex-1 border border-[#5C0E0F] rounded-md p-4">
                                <h3 class="text-xl font-semibold mb-2">Total Students</h3>
                                <p class="text-lg">{{ $totalStudents }}</p>
                            </div>

                            <!-- Total Activities -->
                            <div class="flex-1 border border-[#5C0E0F] rounded-md p-4">
                                <h3 class="text-xl font-semibold mb-2">Total Activities</h3>
                                <p class="text-lg">{{ $totalActivities }}</p>
                            </div>

                            <!-- Total Fees -->
                            <div class="flex-1 border border-[#5C0E0F] rounded-md p-4">
                                <h3 class="text-xl font-semibold mb-2">Total Fees</h3>
                                <p class="text-lg">{{ $totalFees }}</p>
                            </div>


                        </div>
                    </div>
                    <!-- Link to Fees -->
                    <a href="{{ route('students.index') }}" class="text-blue-500 hover:text-blue-700 text-lg font-semibold">
                        View All Students
                    </a>
                    <!-- Container for Charts -->
                    <div class="border border-gray-300 rounded-md p-4 mb-6">
                        <div class="flex flex-wrap justify-between gap-6">
                            <!-- Organization Counts Chart -->
                            <div class="flex-1 min-w-[300px] max-w-[400px]" style="height: 300px;">
                                <h3 class="text-xl font-semibold mb-2">Organization Counts</h3>
                                <canvas id="organizationBarChart" style="width: 100%; height: 100%;"></canvas>
                            </div>

                            <!-- Program Counts Chart -->
                            <div class="flex-1 min-w-[300px] max-w-[400px]" style="height: 300px;">
                                <h3 class="text-xl font-semibold mb-2">Course Counts</h3>
                                <canvas id="programBarChart" style="width: 100%; height: 100%;"></canvas>
                            </div>

                            <!-- Year Counts Chart -->
                            <div class="flex-1 min-w-[300px] max-w-[400px]" style="height: 300px;">
                                <h3 class="text-xl font-semibold mb-2">Year Counts</h3>
                                <canvas id="yearBarChart" style="width: 100%; height: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Link to Sanctions -->

                    <div class="flex justify-between mb-6">
                        <a href="{{ route('sanctions.index') }}" class="text-blue-500 hover:text-blue-700 text-lg font-semibold">
                            View All Sanctions
                        </a>

                        <a href="{{ route('clearances.index') }}" class="text-blue-500 hover:text-blue-700 text-lg font-semibold mb-4 inline-block">
                            View All Clearances
                        </a>
                    </div>

                 <!-- Container for Total Sanctions and Clearance Status -->
                 <div class="border border-gray-300 rounded-md p-4 mb-6">
                    <div class="flex gap-6">
                        <!-- Total Sanctions -->
                        <div class="flex-1 border border-[#5C0E0F] rounded-md p-4">
                            <h3 class="text-xl font-semibold mb-2">Total Sanctions</h3>
                            <p class="text-lg">{{ $totalSanctions }}</p>
                        </div>

                        <!-- Total Clearance -->
                        <div class="flex-1 border border-[#5C0E0F] rounded-md p-4">

                            <h3 class="text-xl font-semibold mb-2">Clearance Status</h3>
                            <ul class="list-disc pl-5">
                                <li>Eligible: {{ $eligibleCount }}</li>
                                <li>Not Eligible: {{ $notEligibleCount }}</li>
                                <li>Cleared: {{ $clearedCount }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctxOrgBar = document.getElementById('organizationBarChart').getContext('2d');
            const ctxProgBar = document.getElementById('programBarChart').getContext('2d');
            const ctxYearBar = document.getElementById('yearBarChart').getContext('2d');

            // Organization Bar Chart
            new Chart(ctxOrgBar, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($organizationCounts)),
                    datasets: [{
                        label: 'Number of Students',
                        data: @json(array_values($organizationCounts)),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(255, 205, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Program Bar Chart
            new Chart(ctxProgBar, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($programCounts)),
                    datasets: [{
                        label: 'Number of Students',
                        data: @json(array_values($programCounts)),
                        backgroundColor: 'rgba(255, 159, 64, 0.7)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Year Bar Chart
            new Chart(ctxYearBar, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($yearCounts)),
                    datasets: [{
                        label: 'Number of Students',
                        data: @json(array_values($yearCounts)),
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-officer-app-layout>
