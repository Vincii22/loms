<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Automated Management System for LICOES Organization</title>
    <link rel="icon" href="{{ asset('images/licoes.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


     <!-- jQuery -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

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
            min-height: 100vh;
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

        .dt-button{
            border-radius: 5px !important;
            margin: 0 !important;
            border-right: 1px solid #5C0E0F !important;
            background: white !important;
            font-size: .875rem !important;
            line-height: 1.25rem !important;
            padding: 5px 20px 5px 20px !important;
            outline: none !important;
            border: none !important;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1) !important;
        }

        .dt-button:hover{
            background: #5C0E0F !important;
            color: white !important;
            transition: .3s ease;
        }
        .dt-buttons{
            margin-bottom: 20px;
        }
        .dataTables_info{
            font-size: .800rem;
            margin: 10px 0;
            line-height: 1rem;
        }
        
        .dataTables_paginate {
            margin: 10px 0;
        }

        .paginate_button{
            border-radius: 5px !important;
            border-right: 1px solid #5C0E0F !important;
            background: white !important;
            outline: none !important;
            font-size: .800rem;
            line-height: 1rem;
            border: none !important;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1) !important;
        }
        .paginate_button:hover{
            background: #805C0E0F !important;
            color: #ccc !important;
            transition: .3s ease;
        }

        .dataTables_filter{
            font-size: .875rem;
            line-height: 1.25rem;

        }
        .dataTables_filter input{
            height: 25px !important; 
        }

    </style>
</head>
<body class="font-sans antialiased">

    <!-- Sidebar -->
    <aside class="fixed-sidebar">
        @include('admin.layouts.sidebar')
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper !min-h-full overflow-auto pb-3">
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
            @yield('content')
            {{ $slot }}
        </main>

        <footer>
            <div class="px-[150px] mt-5">
                <hr style="border: 2px solid #5C0E0F; " >
            <div class="text-center text-sm mt-2">
                Copyright @ {{ date('Y') }} MILBOR Tech <span class="text-gray-400 ml-2">All rights reserved.</span>
            </div>
            </div>
        </footer>
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

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
</body>
</html>
