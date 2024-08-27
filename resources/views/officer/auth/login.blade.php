<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="flex flex-col lg:flex-row items-center lg:items-center bg-white rounded-lg shadow-lg w-full h-full">
        <!-- Left Side: Logos -->
        <div class="flex-1 p-6 h-full flex flex-col items-center justify-center">
            <!-- League Logo -->
            <div class="text-center mb-8 flex flex-col items-center">
                <img src="{{ asset('images/licoes.png') }}" alt="League Logo" class="h-72">
                <h2 class="mt-4 text-2xl font-bold text-[#5C0E0F]">
                    LEAGUE OF INTEGRATED<br>
                    COMPUTER AND ENGINEERING<br>
                    STUDENTS
                </h2>
            </div>

            <!-- Organization Logos -->
            <div class="flex justify-center space-x-4">
                <img src="{{ asset('images/csit.png') }}" alt="PICE Logo" class="h-32">
                <img src="{{ asset('images/iiee.png') }}" alt="CSIT Logo" class="h-32">
                <img src="{{ asset('images/pice.jpg') }}" alt="IIEE Logo" class="h-32">
                <img src="{{ asset('images/pice.jpg') }}" alt="SLISS Logo" class="h-32">
            </div>
        </div>


        <!-- Right Side: Login -->

        <div class="bg-[#5C0E0F] text-white relative p-8 lg:ml-4 rounded-3xl h-[63%] w-[45%] md:w-[60%] lg:w-[30%] flex items-center justify-center mr-20"> <!-- Added margin-right -->
            <div class="space-y-6 w-full h-full px-10 py-5">

                <div class="text">
                    <h2 class="text-2xl text-center mb-10">
                        {{ __('Officer Login') }}
                    </h2>
                    <hr class="pb-5">
                </div>
                <!-- Session Status -->

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('officer.login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full !bg-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full !bg-white"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-200">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-grey-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif



            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
</div>

</div>
</body>
</html>
