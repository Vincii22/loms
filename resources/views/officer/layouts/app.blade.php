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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/layout.css'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">


    <style>
        /* Fixed navigation bar */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px; /* Adjust as needed */
            z-index: 1000;
            background-color: white;
        }

        /* Fixed sidebar below the navigation bar */
        .fixed-sidebar {
            position: fixed;
            top: 64px; /* Adjust to the height of the fixed header */
            left: 0;
            width: 240px; /* Adjust as needed */
            height: calc(100vh - 64px); /* Full height minus header height */
            background-color: white;
            border-right: 1px solid #ddd;
            z-index: 999;
        }

        /* Content wrapper adjusts for header and sidebar */
        .content-wrapper {
            margin-top: 64px; /* Adjust to the height of the fixed header */
            margin-left: 240px; /* Adjust to the width of the fixed sidebar */
            display: flex;
            flex-direction: column;
            height: calc(100vh - 64px); /* Full height minus header height */
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
                top: 64px; /* Adjust to the height of the fixed header */
            }

            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Fixed Navigation -->
    <header class="fixed-header">
        @include('officer.layouts.navigation')
    </header>

    <!-- Sidebar -->
    <aside class="fixed-sidebar">
        @include('officer.layouts.sidebar')
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow mb-4">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Main Content -->
        <main class="main-content p-6">
            @yield('content')
            {{ $slot }}
        </main>
    </div>

    @yield('scripts')
</body>
</html>
