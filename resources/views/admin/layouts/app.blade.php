<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Fixed sidebar below the navigation bar */
        .fixed-sidebar {
            position: fixed;
            left: 0;
            width: 240px; /* Adjust as needed */
            height: calc(100vh - 64px); /* Full height minus header height */
            background-color: white;
            border-right: 1px solid #ddd;
            z-index: 999;
        }

        /* Content wrapper adjusts for header and sidebar */
        .content-wrapper {
            margin-left: 240px; /* Adjust to the width of the fixed sidebar */
            display: flex;
            flex-direction: column;
            height: calc(100vh - 64px); /* Full height minus header height */
            background-color: #f9f9f9; /* Light background for content */
        }

        /* Ensure the content does not overlap */
        .main-content {
            flex: 1;
            overflow-y: auto;
            background-color: white;
        }

        @media (max-width: 768px) {
            .fixed-sidebar {
                width: 100%;
                height: auto;
            }

            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">

    <!-- Sidebar -->
    <aside class="fixed-sidebar">
        @include('admin.layouts.sidebar')
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper !h-full overflow-auto pb-3">
        <!-- Page Heading -->
        @isset($header)
            <div class="flex justify-center">
                <header class="bg-white shadow mb-4 p-4 !mt-5 !ml-5 w-[95%] flex justify-between rounded-[10px]">
                    <div class="max-w-7xl mx-10">
                        {{ $header }}
                    </div>
                    <div class="mr-10 text-sm" id="currentTime"></div>
                </header>
            </div>
        @endisset

        <!-- Main Content -->
        <main class="main-content mr-6 ml-10 !bg-transparent">
            @yield('AdminContent')
            {{ $slot }}
        </main>
    </div>

    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const currentTimeElement = document.getElementById('currentTime');
        
        function updateTime() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            
            // Convert hours to 12-hour format
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            hours = String(hours).padStart(2, '0');
            
            currentTimeElement.textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
        }

        // Update time every second
        setInterval(updateTime, 1000);

        // Initial update
        updateTime();
    });
    </script>
</body>
</html>
