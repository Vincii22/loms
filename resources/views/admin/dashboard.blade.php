<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }} / 
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600">Dashboard</a>
        </h2>
    </x-slot>

    <div class=" shadow mb-4 px-5 py-5 rounded-[10px]" style=" background: linear-gradient(to right, #c43e3e 20%, #5C0E0F);">
    <!-- <div class=" shadow mb-4 px-5 py-5 rounded-[10px]" style=" background-image: linear-gradient(to right, #ffffff, #f0e1f9, #f0c0e7, #f69cc6, #f87698, #e96079, #d84b59, #c4383a, #a92d2f, #8e2324, #751819, #5c0e0f);"> -->
        <div class="flex justify-between px-10 text-white">
            <div class="">
                <div class="flex">
                    <h1 class="mr-2">Welcome,</h1>
                    <div class="text-transform: uppercase">{{ Auth::user()->name }}</div>
                </div>
                <div class="">
                    <h2 class="w-[50rem] mt-8">
                        
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, repellendus? Ut sed commodi modi quidem est perferendis amet. Eligendi eaque laboriosam esse?
                    </h2>
                </div>
            </div>
            <div class="">
                <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="block h-[120px] w-auto fill-current">
            </div>
        </div>
    </div>

    <!-- Statistics Container -->
    <div class="max-w-7xl flex gap-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-2/3 sm:px-6 lg:px-8">
            <div class="p-6">
                <div class="flex space-x-6">
                    <!-- Total Students -->
                    <div class="flex-1 border border-gray-300 rounded-md py-2 px-4 bg-gray-50">
                        <h3 class="text-xl">Total Students</h3>
                    </div>

                    <!-- Total Officers -->
                    <div class="flex-1 border border-gray-300 rounded-md py-2 px-4 bg-gray-50">
                        <h3 class="text-xl">Total Officers</h3>
                    </div>

                    <!-- Total Admins -->
                    <div class="flex-1 border border-gray-300 rounded-md py-2 px-4 bg-gray-50">
                        <h3 class="text-xl">Total Admins</h3>
                    </div>
                </div>

                <!-- Container for Charts -->
                <div class="rounded-md p-4 mb-6 mt-10">
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
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-1/3">
            <div class="p-6">
                <h1 class="text-center text-lg font-semibold text-[#5C0E0F] pb-4">Upcoming Activities</h1>
                <div class="flex flex-col gap-4">
                    <div class="border border-gray-300 rounded-md p-4 bg-gray-50">
                        <h3 class="text-xl font-semibold mb-2">Activity 1</h3>
                        <p class="text-lg">Details about upcoming activity 1.</p>
                    </div>

                    <div class="border border-gray-300 rounded-md p-4 bg-gray-50">
                        <h3 class="text-xl font-semibold mb-2">Activity 2</h3>
                        <p class="text-lg">Details about upcoming activity 2.</p>
                    </div>

                    <div class="border border-gray-300 rounded-md p-4 bg-gray-50">
                        <h3 class="text-xl font-semibold mb-2">Activity 3</h3>
                        <p class="text-lg">Details about upcoming activity 3.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</x-admin-app-layout>