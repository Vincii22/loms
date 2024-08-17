<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-64 bg-white fixed top-16 left-0 h-[calc(100vh-64px)] border-r border-gray-200">
    <!-- Sidebar Header -->
    <div class="flex flex-col h-full">
        <!-- Logo and User Info -->
        <header class="flex flex-col items-center justify-center border-b border-gray-200" style="height: 25%;">
            <div class="flex items-center justify-center w-full h-20">
                <!-- Replace with your logo -->
                <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="h-28">
            </div>
            <div class="text-center border-t border-gray-200 mt-4 p-2 w-full" style="background-color: #5C0E0F; height: 30%;">
                <p class="text-xl font-semibold text-white">{{ Auth::user()->name }}</p>
            </div>
        </header>

        <!-- Sidebar Content -->
        <div class="flex-1 overflow-auto p-4" style="background-color: #5C0E0F; color: white; height: 65%;">
            <nav>
                <ul class="space-y-4">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-gray-300">Dashboard</a></li>
                    <li><a href="{{ route('finance.index') }}" class="hover:text-gray-300">Attendance</a></li>
                    <li><a href="{{ route('finance.index') }}" class="hover:text-gray-300">Finance</a></li>
                    <li><a href="{{ route('finance.index') }}" class="hover:text-gray-300">Sanction</a></li>
                    <li><a href="{{ route('finance.index') }}" class="hover:text-gray-300">Clearance</a></li>
                    <li><a href="{{ route('finance.index') }}" class="hover:text-gray-300">Profile</a></li>
                    <li><a href="{{ route('dashboard') }}" class="hover:text-gray-300">Settings</a></li>
                    <li><a href="{{ route('dashboard') }}" class="hover:text-gray-300">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <footer class="flex items-center justify-center p-4 border-t border-gray-200" style="height: 5%;">
            <p class="text-sm text-gray-500">© {{ date('Y') }} Your Company</p>
        </footer>
    </div>
</aside>
