<x-guest-layout>
    <div style="" class="h-[550px] flex design overflow">
        <!-- Left Section (Login Form) -->
        <div class="flex items-center justify-center w-full md:w-1/2 bg-white p-8">
            <div class="w-full max-w-md">
                <h1 class="text-center text-4xl font-bold text-black mb-8">Admin Login</h1>
                <h1 class="text-center text-lg font-bold text-[#c43e3e]">Organization Management System</h1>

                <div class="px-10">
                    <hr class="border-black my-10">
                </div>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
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

        <!-- Right Section (Background with Info) -->
        <div class="hidden md:flex md:w-1/2 bg-cover bg-no-repeat bg-center" style="background-image: url('{{ asset('images/bfe6d0c4-dfbf-4c0c-8c54-1db80dd644ba.jpeg') }}');">
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
    
<style>
    .design::after{
        content: "";
        background-image: url('{{ asset('images/bg-design.png') }}');
        position: absolute;
        left: -200px;
        top: -300px;
        height: 600px;
        width: 600px;
        transform: rotate(170deg);
        filter: hue-rotate();
    }
    .design::before{
        content: "";
        background-image: url('{{ asset('images/bg-design.png') }}');
        position: absolute;
        left: 90rem;
        top: 700px;
        height: 600px;
        width: 600px;
        transform: rotate(0deg);
        filter: hue-rotate();
    }
</style>
</x-guest-layout>

