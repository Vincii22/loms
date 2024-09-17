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
    </head>
    <body class="font-sans text-gray-900 antialiased overflow-hidden">
        <div class="hidden md:flex md:w-full bg-cover bg-no-repeat bg-center" style="background-image: url('{{ asset('images/a22bdfe2-9782-4e40-ac24-750136e7d7b9.jpeg') }}');">
            <div class="min-h-screen w-full flex flex-col items-center justify-center bg-[#5c0e0f] bg-opacity-60 h-full  text-white p-10">
                
                <div class="flex justify-center items-center bg-[#5c0e0f] sm:justify-center pt-6 sm:pt-0 h-6/6 w-1/2 p-10 rounded-lg">
                    <div class="flex flex-col items-center justify-center gap-16">
                        <div class="text-center animate-fadeIn mb-10 mt-10">
                            <div class="rotating-border">
                                <img src="{{ asset('images/licoes.png') }}" alt="" class="w-40 h-40 logo">
                            </div>
                        </div>
                        <div class="">
                            <div class="mb-4 text-gray-600 dark:text-white">
                                {{ __('Thank you for registering! Your account is currently under review by an administrator. We will notify you once your registration has been approved and your account is active.') }}
                            </div>

                            <div class="mt-4 w-full flex items-center justify-between">
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf

                                    <div>
                                        <x-primary-button>
                                            {{ __('Request a New Email Approval') }}
                                        </x-primary-button>
                                    </div>
                                </form>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="bg-[#c43e3e] px-5 py-2 underline text-sm text-gray-600 dark:text-white hover:text-gray-900 dark:hover:text-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkStatusInterval = setInterval(() => {
                fetch('{{ route('check.status') }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'active') {
                        clearInterval(checkStatusInterval); // Stop checking
                        window.location.href = '{{ route('dashboard') }}'; // Redirect to the dashboard
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                });
            }, 5000); // Check every 5 seconds
        });


            </script>

            
<style>
    @keyframes rotateBorder {
    0% {
    transform: rotate(0deg);
    }
    100% {
    transform: rotate(360deg);
    }
    }

    .rotating-border {
    position: relative;
    background: #5c0e0f;
    border-radius: 50%;
    width: 200px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    }

    .rotating-border::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border: 9px solid;
    border-color: #5c0e0f white #5c0e0f white;
    border-radius: 50%;
    animation: rotateBorder 4s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    z-index: 1;
    }

    @keyframes fadeIn {
    0% {
    opacity: 0;
    }
    100% {
    opacity: 1;
    }
    }

    .logo {
    position: relative;
    z-index: 2; 
    }
</style>
    </body>
</html>


