
<aside class="w-64 bg-white fixed left-0 pt-5 h-[100vh] border-r border-gray-200">
    <!-- Sidebar Header -->
    <div class="flex flex-col h-full md:relative">
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
                        <span class="text-[.7rem] uppercase"> {{ Auth::user()->name }}</span>
                    </div>
                    <div class="">
                        @include('layouts.navigation')
                    </div>
                </div>
                <hr class="border border-black mt-3">
                </div>
        </header>


        <!-- Sidebar Content -->
        <div class="flex-1 overflow-auto py-4 w-64" style=" color: black; height: 65%;">
            <nav>
                <ul class="space-y-9">
                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('dashboard') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('dashboard') }}" class="relative  hover:text-gray-300  px-10 ">Dashboard</a></li>
                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('sAttendance.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('sAttendance.index') }}" class="relative  hover:text-gray-300  px-10 ">Attendance</a></li>
                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('finance.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('finance.index') }}" class="relative  hover:text-gray-300  px-10 ">Finance</a></li>
                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('finance.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('finance.index') }}" class="relative  hover:text-gray-300  px-10 ">Sanction</a></li>
                    <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('finance.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('finance.index') }}" class="relative  hover:text-gray-300  px-10 ">Clearance</a></li>
                </ul>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <footer class="flex items-center justify-center p-4 border-t border-gray-200" style="height: 5%;">
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
                <li><a href="{{ route('dashboard') }}" class="hover:text-gray-300">Dashboard</a></li>
                <li><a href="{{ route('sAttendance.index') }}" class="hover:text-gray-300">Attendance</a></li>
                <li><a href="{{ route('finance.index') }}" class="hover:text-gray-300">Finance</a></li>
                <li><a href="{{ route('finance.index') }}" class="hover:text-gray-300">Sanction</a></li>
                <li><a href="{{ route('finance.index') }}" class="hover:text-gray-300">Clearance</a></li>

            </ul>
        </nav>
    </div>
</div>

<!-- JavaScript to toggle mobile menu -->
<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        var mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.remove('hidden');
        } else {
            mobileMenu.classList.add('hidden');
        }
    });
</script>










<style>
.nav-links:hover{
        background-color: maroon;
        color: white;
        transition: .4s ease-in-out;
     }
</style>