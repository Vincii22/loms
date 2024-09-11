<aside class="fixed top-16 left-0 w-64 bg-white border-r border-gray-200 md:w-64 md:h-[calc(100vh-64px)]">
    <!-- Sidebar Header -->
    <div class="flex flex-col h-full md:relative">
        <!-- Logo and User Info -->
        <header class="flex flex-col items-center justify-center border-b border-gray-200 md:h-1/4">
            <div class="flex items-center justify-center w-full h-20">
                <!-- Replace with your logo -->
                <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="h-28">
            </div>
            <div class="text-center border-t border-gray-200 mt-4 p-2 w-full bg-[#5C0E0F] md:h-1/4">
                <p class="text-xl font-semibold text-white">{{ Auth::user()->name }}</p>
            </div>
        </header>

        <!-- Sidebar Content -->
        <div class="flex-1 overflow-auto p-4 bg-[#5C0E0F] text-white md:h-3/4">
            <nav>
                <ul class="space-y-4">
                    <li><a href="{{ route('officer.dashboard') }}" class="hover:text-gray-300">Dashboard</a></li>
                    <li><a href="{{ route('students.index') }}" class="hover:text-gray-300">Students</a></li>

                    <!-- Dropdown for Attendance -->
                    <li>
                        <button class="w-full text-left flex justify-between items-center focus:outline-none" onclick="toggleDropdown('attendance-dropdown')">
                            Attendance
                            <svg class="h-5 w-5 transition-transform duration-200 transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul id="attendance-dropdown" class="hidden space-y-2 ml-4">
                            <li><a href="{{ route('activities.index') }}" class="hover:text-gray-300">Manage Activities</a></li>
                            <li><a href="{{ route('attendance.index') }}" class="hover:text-gray-300">Manage Attendance</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown for Finance -->
                    <li>
                        <button class="w-full text-left flex justify-between items-center focus:outline-none" onclick="toggleDropdown('finance-dropdown')">
                            Finance
                            <svg class="h-5 w-5 transition-transform duration-200 transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul id="finance-dropdown" class="hidden space-y-2 ml-4">
                            <li><a href="{{ route('fees.index') }}" class="hover:text-gray-300">Manage Fees</a></li>
                            <li><a href="{{ route('finances.index') }}" class="hover:text-gray-300">Manage Finances</a></li>
                            {{-- <li><a href="{{ route('audit.index') }}" class="hover:text-gray-300">Manage Audit</a></li> --}}
                        </ul>
                    </li>

                    <li><a href="{{ route('sanctions.index') }}" class="hover:text-gray-300">Sanction</a></li>
                    <li><a href="{{ route('clearances.index') }}" class="hover:text-gray-300">Clearance</a></li>

                    <!-- Dropdown for Reports -->
                    <li>
                        <button class="w-full text-left flex justify-between items-center focus:outline-none" onclick="toggleDropdown('reports-dropdown')">
                            Reports
                            <svg class="h-5 w-5 transition-transform duration-200 transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul id="reports-dropdown" class="hidden space-y-2 ml-4">
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

        <!-- Sidebar Footer -->
        <footer class="flex items-center justify-center p-4 border-t border-gray-200 md:absolute md:bottom-0 w-full">
            <p class="text-sm text-gray-500">© {{ date('Y') }} Your Company</p>
        </footer>
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
                    <ul id="mobile-reports-dropdown" class="hidden space-y-2 ml-4">
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
