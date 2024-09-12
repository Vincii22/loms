<aside class="fixed top-16 left-0 w-24 bg-[#5C0E0F] border-r border-gray-200 md:w-24 md:h-[calc(100vh-64px)] ">
    <!-- Sidebar Header -->
    <div class="flex flex-col h-full md:relative pl-2">
        <!-- Sidebar Content -->
        <div class="flex-1 overflow-x-visible overflow-y-scroll p-4 text-white md:h-3/4 scrollbar-hidden w-[230px]">
            <nav>
                <ul class="space-y-9">
                    <li class="flex items-center justify-center relative hover-container">
                        <a href="{{ route('officer.dashboard') }}" class="hover:text-gray-300 relative ">
                            <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[50px]">
                            <span>
                                Dashboard
                            </span>
                        </a>
                    </li>
                    <li class="flex items-center justify-center relative hover-container">
                        <a href="{{ route('students.index') }}" class="hover:text-gray-300 relative ">
                            <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[50px]">
                            <span>
                                Students
                            </span>
                        </a>
                    </li>

                    <!-- Dropdown for Attendance -->
                    <li class="relative hover-container-button">
                        <div class="flex items-center justify-center">
                            <button class="w-full  focus:outline-none  relative" onclick="toggleDropdown('attendance-dropdown')">
                                <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[50px] ">
                                <span>
                                    Attendance
                                </span>
                            </button>
                        </div>
                        <ul id="attendance-dropdown" class="hidden space-y-2 ml-4 mt-7 ">
                            <li class="hover-container-dropdown">
                                <a href="{{ route('activities.index') }}" class="hover:text-gray-300">
                                    <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[40px]">
                                    <span>
                                        alskjdhlaksd
                                    </span>
                                </a></li>
                            <li class="hover-container-dropdown"><a href="{{ route('attendance.index') }}" class="hover:text-gray-300">
                                <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[40px]">
                                <span>
                                    asdasdasdasdasdasdasdasdasd
                                </span>
                            </a></li>
                        </ul>
                    </li>

                    <!-- Dropdown for Finance -->
                    <li class=" relative hover-container-button">
                        <div class="flex items-center justify-center">
                            <button class="w-full  focus:outline-none relative" onclick="toggleDropdown('finance-dropdown')">
                                <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[50px] ">
                                <span>
                                    Finance
                                </span>
                            </button>
                        </div>
                        <ul id="finance-dropdown" class="hidden space-y-2 ml-4 mt-7">
                            <li class="hover-container-dropdown">
                                <a href="{{ route('fees.index') }}" class="hover:text-gray-300">
                                    <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[40px]">
                                    <span>
                                        asdasdasdasdasdasdasdasdasd
                                    </span>
                                </a>
                            </li>
                            <li class="hover-container-dropdown">
                                <a href="{{ route('finances.index') }}" class="hover:text-gray-300">
                                    <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[40px]">
                                    <span>
                                        asdasdasdasdasdasdasdasdasd
                                    </span>
                                </a>
                            </li>
                            {{-- <li><a href="{{ route('audit.index') }}" class="hover:text-gray-300">Manage Audit</a></li> --}}
                        </ul>
                    </li>

                    <li class="flex items-center justify-center relative hover-container">
                        <a href="{{ route('sanctions.index') }}" class="hover:text-gray-300 relative ">
                            <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[50px]">
                            <span>
                                Sanction
                            </span>
                        </a>
                    </li>
                    
                    <li class="flex items-center justify-center relative hover-container">
                        <a href="{{ route('clearances.index') }}" class="hover:text-gray-300 relative ">
                            <img src="{{ asset('images/dashboard.png') }}" alt="PICE Logo" class="h-[50px]">
                            <span>
                                Clearance
                            </span>
                        </a>
                    </li>

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

<style>

    /* Hide scrollbar for Chrome */
    .scrollbar-hidden::-webkit-scrollbar {
    display: none;
    }

    .scrollbar-hidden{
        display: flex;
        flex-direction: start;
    }

    .hover-container img{
        /* -webkit-filter: invert(100%) */
    /* filter: invert(100%); */
    padding: 3px;
    background-color: white;
    border-radius: 10px;
    }

    .hover-container-button img{
        /* -webkit-filter: invert(100%) */
    /* filter: invert(100%); */
    padding: 3px;
    background-color: white;
    border-radius: 10px;
    }

    .hover-container span, 
    .hover-container-button span{
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        z-index: 999999;
        transition: .4s linear;
        color: white;
        margin-bottom: 10px;
        top: 0;
        opacity: 0;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
    }
    .hover-container-button span{
        left: 5px ;
    }

    .hover-container:hover span, 
    .hover-container-button:hover span{
        transform: translateX(50%);
        transition-delay: .3s;
        opacity: 1;
        background-color: #5C0E0F;
        padding: 0 10px 0 10px ;
        border-radius: 0px 10px 10px 0;
        width: 120px;
    }

    .hover-container-dropdown span{
        position: absolute;
        width: 100%;
        height: 50px;
        left: 0;
        z-index: 999999;
        transition: .4s linear;
        color: white;
        margin-bottom: 10px;
        opacity: 0;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
    }
    .hover-container-dropdown:nth-child(1) span {
        top: 65px;
        left: -5px;
    }
    .hover-container-dropdown:nth-child(2) span {
        top: 125px;
        left: -5px;
    }

    .hover-container-dropdown:hover span{
        width: 130px;
    }

</style>