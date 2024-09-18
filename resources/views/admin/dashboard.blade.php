<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Admin') }} /
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600">Dashboard</a>
        </h2>
    </x-slot>

    <div class="shadow mb-4 px-5 py-5 rounded-[10px]" style="background: linear-gradient(to right, #c43e3e 20%, #5C0E0F);">
        <div class="flex justify-between px-10 text-white">
            <div>
                <div class="flex">
                    <h1 class="mr-2">Welcome,</h1>
                    <div class="text-transform: uppercase">{{ Auth::user()->name }}</div>
                </div>
                <div>
                    <h2 class="w-[50rem] mt-8">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, repellendus? Ut sed commodi modi quidem est perferendis amet. Eligendi eaque laboriosam esse?
                    </h2>
                </div>
            </div>
            <div>
                <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="block h-[120px] w-auto fill-current">
            </div>
        </div>
    </div>

    <!-- Statistics Container -->
    <div class="max-w-full flex gap-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-2/3 sm:px-6 lg:px-8">
            <div class="p-6">
                <div class="flex space-x-6">
                    <!-- Total Students -->
                    <div class="flex-1 border border-gray-300 rounded-md py-2 px-4 bg-gray-50">
                        <h3 class="text-lg">Total Students</h3>
                        <p>{{ $totalStudents ?? 'No students available' }}</p>
                    </div>

                    <!-- Total Officers -->
                    <div class="flex-1 border border-gray-300 rounded-md py-2 px-4 bg-gray-50">
                        <h3 class="text-lg">Total Officers</h3>
                        <p>{{ $totalOfficers ?? 'No officers available' }}</p>
                    </div>

                    <!-- Total Admins -->
                    <div class="flex-1 border border-gray-300 rounded-md py-2 px-4 bg-gray-50">
                        <h3 class="text-lg">Total Admins</h3>
                        <p>{{ $totalAdmins ?? 'No admins available' }}</p>
                    </div>
                </div>

                <!-- Container for Charts -->
                <div class="rounded-md p-4 mb-6 mt-10">
                    <div class="flex flex-wrap justify-between gap-6">
                        <!-- Organization Counts Chart -->
                        <div class="flex-1 min-w-[300px] max-w-[400px]" style="height: 300px;">
                            <h3 class="text-lg font-semibold mb-2">Organization Counts</h3>
                            <canvas id="organizationBarChart" style="width: 100%; height: 100%;"></canvas>
                        </div>

                        <!-- Program Counts Chart -->
                        <div class="flex-1 min-w-[300px] max-w-[400px]" style="height: 300px;">
                            <h3 class="text-lg font-semibold mb-2">Course Counts</h3>
                            <canvas id="programBarChart" style="width: 100%; height: 100%;"></canvas>
                        </div>

                        <!-- Year Counts Chart -->
                        <div class="flex-1 min-w-[300px] max-w-[400px]" style="height: 300px;">
                            <h3 class="text-lg font-semibold mb-2">Year Counts</h3>
                            <canvas id="yearBarChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Activities Section -->
        <div class="w-1/3 flex flex-col gap-4">
            <div class="bg-white shadow-sm sm:rounded-lg h-fit mb-3">
                <div class="p-6">
                    <h1 class="text-center text-lg font-semibold text-[#5C0E0F] pb-4">Upcoming Activities</h1>
                    @if($activities->isEmpty())
                        <p class="text-center">No upcoming activities</p>
                    @else
                        <ul>
                            @foreach($activities as $activity)
                                <li>{{ $activity->name }} - {{ $activity->start_time->format('M d, Y') }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>


         <!-- Pending Approval Section -->
<div class="bg-white shadow-sm sm:rounded-lg h-fit">
    <div class="p-6">
        <h1 class="text-center text-lg font-semibold text-[#5C0E0F] pb-4">Pending Approval</h1>
        <div class="flex flex-col gap-4 max-h-[420px] overflow-auto custom-scroll">
            <!-- Pending Users -->
            @if($pendingUsers->isEmpty() && $pendingOfficers->isEmpty())
                <p class="text-center">No pending approvals</p>
            @else
                @foreach($pendingUsers as $user)
                    <div class="flex justify-between px-5 rounded-md p-4 bg-gray-50">
                        <h3 class="text-sm font-semibold mb-2">{{ $user->name }}</h3>
                        <p class="text-sm">User</p> <!-- User type -->
                    </div>
                @endforeach

                @foreach($pendingOfficers as $officer)
                    <div class="flex justify-between px-5 rounded-md p-4 bg-gray-50">
                        <h3 class="text-sm font-semibold mb-2">{{ $officer->name }}</h3>
                        <p class="text-sm">Officer</p> <!-- User type -->
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

        </div>
    </div>

    <!-- Load Chart.js and Initialize Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Organization Counts Chart
        const organizationCountsData = @json(array_values($organizationCounts));
        const organizationLabels = @json(array_keys($organizationCounts));

        const organizationBarChart = new Chart(document.getElementById('organizationBarChart'), {
            type: 'bar',
            data: {
                labels: organizationLabels,
                datasets: [{
                    label: 'Organization Counts',
                    data: organizationCountsData,
                    backgroundColor: '#c43e3e'
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

        // Program Counts Chart
        const programCountsData = @json(array_values($programCounts));
        const programLabels = @json(array_keys($programCounts));

        const programBarChart = new Chart(document.getElementById('programBarChart'), {
            type: 'bar',
            data: {
                labels: programLabels,
                datasets: [{
                    label: 'Course Counts',
                    data: programCountsData,
                    backgroundColor: '#5C0E0F'
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

        // Year Counts Chart
        const yearCountsData = @json(array_values($yearCounts));
        const yearLabels = @json(array_keys($yearCounts));

        const yearBarChart = new Chart(document.getElementById('yearBarChart'), {
            type: 'bar',
            data: {
                labels: yearLabels,
                datasets: [{
                    label: 'Year Counts',
                    data: yearCountsData,
                    backgroundColor: '#c43e3e'
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
</x-admin-app-layout>
