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
    @vite(['resources/css/app.css', 'resources/css/layout.css'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    <style>
        /* Ensure the sidebar is properly sized */
        .fixed-sidebar {
            position: fixed;
            top: 0; /* Same as before */
            left: 0;
            width: 6rem; 
            height: calc(100vh - 64px); /* Same as before */
            background-color: white;
            border-right: 1px solid #ddd;
            z-index: 999;
            box-sizing: border-box; /* Ensure padding/border don't affect width */
        }

        /* Ensure the content wrapper is correctly positioned */
        .content-wrapper {
            margin-left: 240px; /* Ensure this matches the sidebar width */
            display: flex;
            flex-direction: column;
            height: calc(100vh - 64px); /* Same as before */
            box-sizing: border-box; /* Ensure padding/border don't affect layout */
        }

        /* Handle smaller screen sizes */
        @media (max-width: 768px) {
            .fixed-sidebar {
                width: 100%; /* Sidebar becomes full width */
                height: auto; /* Sidebar adjusts its height */
            }

            .content-wrapper {
                margin-left: 0; /* No margin for small screens */
                margin-top: auto; /* Adjust margin-top to fit */
            }
        }

    </style>
</head>
<body class="font-sans antialiased ">
    <!-- Sidebar -->
    <aside class="fixed-sidebar">
        @include('layouts.sidebar')
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Main Content -->
        <main class="main-content p-6 !bg-[#f5f5f5] min-h-[100vh]">
            @isset($header)
                <!-- <header class="bg-white shadow mb-4"> -->
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                <!-- </header> -->
            @endisset

            <!-- Page Content -->
            <div>
                @yield('content')
            </div>
        </main>
    </div>

    @yield('scripts')
</body>
</html>
