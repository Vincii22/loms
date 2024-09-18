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
                        <p class="text-sm font-semibold text-black">Welcome Admin, </p>
                        <span class="text-sm uppercase"> {{ Auth::user()->name }}</span>
                    </div>
                    <div class="">
                        @include('admin.layouts.navigation')
                    </div>
                </div>
            <hr class="border border-black mt-2">

        </div>
        </header>

        <!-- Sidebar Content -->
        <div class="flex-1 overflow-auto mt-16 py-4 w-64" style=" color: black; height: 65%;">
            <nav>
            <ul class="space-y-2 text-sm">
                <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('admin.dashboard') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('admin.dashboard') }}" class="relative  hover:text-gray-300  px-10 ">Dashboard</a></li>
                <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('admins.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('admins.index') }}" class="relative  hover:text-gray-300  px-10 ">Admins</a></li>
                <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('officers.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('officers.index') }}" class="relative  hover:text-gray-300  px-10">Officers</a></li>
                <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('astudents.index') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('astudents.index') }}" class="relative  hover:text-gray-300  px-10 ">Students</a></li>
                <li class="nav-links w-[220px] relative py-3 rounded-r-[10px] {{ request()->routeIs('admin.pending_users') ? 'bg-[maroon] text-white' : '' }}"><a href="{{ route('admin.pending_users') }}" class="relative  hover:text-gray-300  px-10 ">Account Approval</a></li>
            </ul>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <footer class=" bold text-center py-4 border-t border-gray-200" style="height: 10%;">
            <p class="text-sm text-[#5C0E0F] font-semibold">League of Integrated</p>
            <p class="text-sm text-[#5C0E0F] font-semibold">COmputer and Engineering Students</p>
        </footer>
    </div>
</aside>


<style>
     .nav-links:hover{
        background-color: maroon;
        color: white;
        transition: .4s ease-in-out;
     }

</style>
