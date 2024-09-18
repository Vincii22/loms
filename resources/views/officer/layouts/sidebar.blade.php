<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-64 bg-white fixed left-0 pt-5 h-[100vh] border-r border-gray-200">
    <!-- Sidebar Header -->
    <div class="flex flex-col h-full">
        <!-- Logo and User Info -->
        <header class="flex flex-col items-center justify-center" style="height: 25%;">
            <div class="flex items-center justify-center w-full h-20">
                <!-- Replace with your logo -->
                <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="h-32">
            </div>
            <div class=" !px-5 mt-10 p-2 w-full" style=" height: 30%;">
                <div class="flex items-center justify-between">
                    <div class="">
                        <p class="text-sm font-semibold text-black">Welcome, </p>
                        <span class="text-sm uppercase"> {{ Auth::user()->name }}</span>
                    </div>
                    <div class="">
                        @include('officer.layouts.navigation')
                    </div>
                </div>
            <hr class="border border-black mt-2">

        </div>
        </header>

        <!-- Sidebar Content -->
        <div class="flex-1  py-4 w-64" style=" color: black; height: 65%;">
            <nav>
                <ul class="space-y-4 overflow-y-scroll scrollbar-hidden h-[653px]">
                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('officer.dashboard') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('officer.dashboard') }}" class="relative  hover:text-gray-300  px-10 ">Dashboard</a></li>
                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('students.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('students.index') }}" class="relative  hover:text-gray-300  px-10 ">Students</a></li>

                    <!-- Dropdown for Attendance -->
                    <li class="">
                        <button class="nav-links w-[220px] py-3 rounded-r-[10px] flex justify-between px-10 focus:outline-none  relative" onclick="toggleDropdown('attendance-dropdown')">
                            Attendance
                            <svg class="h-5 w-5 transition-transform duration-200 transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul id="attendance-dropdown" class="hidden space-y-2">
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('activities.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('activities.index') }}" class="hover:text-gray-300">Manage Activities</a></li>
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('attendance.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('attendance.index') }}" class="hover:text-gray-300">Manage Attendance</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown for Finance -->
                    <li class="">
                        <button class=" nav-links w-[220px] py-3 rounded-r-[10px] flex justify-between px-10 focus:outline-none relative" onclick="toggleDropdown('finance-dropdown')">
                            Finance
                            <svg class="h-5 w-5 transition-transform duration-200 transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul id="finance-dropdown" class="hidden space-y-2">
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('fees.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('fees.index') }}" class="hover:text-gray-300">Manage Fees</a></li>
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('finances.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('finances.index') }}" class="hover:text-gray-300">Manage Finance</a></li>
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('audit.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('audit.index') }}" class="hover:text-gray-300">Manage Audit</a></li>
                        </ul>
                    </li>

                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('sanctions.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('sanctions.index') }}" class="relative  hover:text-gray-300  px-10 ">Sanction</a></li>
                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('clearances.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('clearances.index') }}" class="relative  hover:text-gray-300  px-10 ">Clearance</a></li>

                    <!-- Dropdown for Reports -->
                    <li >
                            <button class="nav-links w-[220px] py-3 rounded-r-[10px] flex justify-between px-10 focus:outline-none  relative" onclick="toggleDropdown('reports-dropdown')">
                                Reports
                                <svg class="h-5 w-5 transition-transform duration-200 transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        <ul id="reports-dropdown" class="hidden space-y-4">
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('reports.attendance') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('reports.attendance') }}" class="hover:text-gray-300">Attendance Report</a></li>
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('reports.finance') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('reports.finance') }}" class="hover:text-gray-300">Finance Report</a></li>
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('reports.sanction') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('reports.sanction') }}" class="hover:text-gray-300">Sanction Report</a></li>
                            <li class="pl-14 nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('reports.clearance') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('reports.clearance') }}" class="hover:text-gray-300">Clearance Report</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</aside>

<!-- Mobile Menu Toggle -->
<div class="md:hidden fixed top-0 right-0 p-4">
    <button id="menu-toggle" class="text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>
</div>

<!-- Mobile Menu -->
<div id="mobile-menu" class="fixed top-16 right-0 w-full bg-white border-r border-gray-200 md:hidden hidden">
    <div class="flex flex-col p-4">
        <header class="flex flex-col items-center border-b border-gray-200 mb-4">
            <div class="flex items-center justify-center w-full h-20">
                <!-- Replace with your logo -->
                <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="h-28">
            </div>
            <div class="text-center border-t border-gray-200 mt-4 p-2 w-full bg-[#5C0E0F]">
                <p class="text-xl font-semibold text-white">{{ Auth::user()->name }}</p>
            </div>
        </header>

        <nav>
            <ul class="space-y-4">
                <li><a href="{{ route('officer.dashboard') }}" class="hover:text-gray-300">Dashboard</a></li>
                <li><a href="{{ route('students.index') }}" class="hover:text-gray-300">Students</a></li>
                <li><a href="{{ route('attendance.index') }}" class="hover:text-gray-300">Attendance</a></li>
                <li><a href="{{ route('finances.index') }}" class="hover:text-gray-300">Finance</a></li>
                <li><a href="{{ route('sanctions.index') }}" class="hover:text-gray-300">Sanction</a></li>
                <li><a href="{{ route('clearances.index') }}" class="hover:text-gray-300">Clearance</a></li>

                <!-- Dropdown for Reports -->
                  <li>
                    <button class="w-full text-left flex justify-between items-center focus:outline-none" onclick="toggleDropdown('mobile-reports-dropdown')">
                        Reports
                        <svg class="h-5 w-5 transition-transform duration-200 transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul id="mobile-reports-dropdown" class="hidden space-y-2 ">
                        <li><a href="{{ route('reports.attendance') }}" class="hover:text-gray-300">Attendance Report</a></li>
                        <li><a href="{{ route('reports.finance') }}" class="hover:text-gray-300">Finance Report</a></li>
                        <li><a href="{{ route('reports.sanction') }}" class="hover:text-gray-300">Sanction Report</a></li>
                        <li><a href="{{ route('reports.clearance') }}" class="hover:text-gray-300">Clearance Report</a></li>
                        <li><a href="{{ route('reports.student') }}" class="hover:text-gray-300">Student Report</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- JavaScript to toggle dropdowns and mobile menu -->
<script>
    function toggleDropdown(dropdownId) {
        var dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }

    document.getElementById('menu-toggle').addEventListener('click', function() {
        var mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>

<style>
.nav-links:hover{
        background-color: maroon;
        color: white;
        transition: .4s ease-in-out;
     }

    /* Hide scrollbar for Chrome */
    .scrollbar-hidden::-webkit-scrollbar {
    display: none;
    }

</style>
