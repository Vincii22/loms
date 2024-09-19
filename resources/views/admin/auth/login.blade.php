<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Automated Management System for LICOES Organization</title>
    <link rel="icon" href="{{ asset('images/licoes.png') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center overflow-hidden">

<div class="design"></div>
    <div style="" class="h-[550px] flex overflow-hidden z-10 relative max-w-[1186px]">
        <!-- Left Section (Login Form) -->
        <div class="flex flex-col items-center justify-evenly w-full md:w-1/2 bg-white px-3 ">
            <div class="space-y-6 w-full px-10">
            <div class="text">
                <div class="text-center mb-4 relative">
                    <div class="absolute left-0 top-2">
                        <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7" />
                            </svg>
                        </a>
                    </div>
                    <h1 class="text-2xl text-center">Admin Login</h1>
                </div>
                <hr class="pb-5">
            </div>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="px-10">
                    <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="!text-black"/>
                            <x-text-input id="email" class=" !rounded-none !text-black block mt-1 w-full !bg-white custom-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" class="!text-black"/>

                            <x-text-input id="password" class=" !rounded-none !text-black block mt-1 w-full !bg-white custom-input"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-500">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-10">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 dark:text-gray-500 hover:text-gray-900 dark:hover:text-gray-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif

                            <x-primary-button class="ms-3">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
            <hr  class="w-[70%] border-black">

            <div class="flex justify-center space-x-4 ">
                <img src="{{ asset('images/csit.png') }}" alt="PICE Logo" class="h-20">
                <img src="{{ asset('images/iiee.png') }}" alt="CSIT Logo" class="h-20">
                <img src="{{ asset('images/pice.jpg') }}" alt="IIEE Logo" class="h-20">
                <img src="{{ asset('images/sliss.png') }}" alt="SLISS Logo" class="h-20">
            </div>
        </div>
        

        <!-- Right Section (Background with Info) -->
        <div class="hidden md:flex md:w-1/2 bg-cover bg-no-repeat bg-center" style="background-image: url('{{ asset('images/a22bdfe2-9782-4e40-ac24-750136e7d7b9.jpeg') }}');">
            <div class="bg-[#5c0e0f] bg-opacity-90 w-full h-full flex items-center justify-center text-white p-10">
                <div class="text-center">
                    <div class="flex items-center justify-center">
                    <img src="{{ asset('images/licoes.png') }}" alt="" class="w-[300px]">
                    </div>
                    <h1 class="text-2xl font-bold mb-4">LEAGUE OF INTEGRATED COMPUTER AND ENGINEERING STUDENTS</h1>
                    <div class="w-full flex items-center justify-center">
                        <!-- <p class="text-sm leading-relaxed w-[400px]">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec neque tortor. Proin efficitur leo vel ex aliquam ullamcorper.</p> -->
                    </div>
                </div>
            </div>
        </div>
        
</div>

<div class="design2"></div>


<style>
    .design{
        content: "";
        background-image: url('{{ asset('images/bg-design.png') }}');
        position: absolute;
        left: -200px;
        top: -300px;
        height: 600px;
        width: 600px;
        transform: rotate(170deg);
        filter: hue-rotate();
        z-index: 10;
    }
    .design2{
        content: "";
        background-image: url('{{ asset('images/bg-design.png') }}');
        position: absolute;
        right: -300px;
        top: 400px;
        height: 600px;
        width: 600px;
        transform: rotate(0deg);
        filter: hue-rotate();
    }
    .custom-input {
        border: none ;
        border-bottom: 2px solid #800000; 
        background-color: white; 
        outline: none !important; 
        position: relative; 
        padding: 8px 0; 
    }

    .custom-input:focus {
        outline: none !important; 
        border-bottom-color: #fc4646;
    }

</style>

</body>
</html>
