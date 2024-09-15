<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center overflow-hidden ">

    
<div class="design"></div>
    <div style="" class="h-[550px] flex overflow-hidden z-10 relative max-w-[1186px]">
        <!-- Left Section (Login Form) -->
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
        

        <!-- Right Section (Background with Info) -->
        

        <div class="flex flex-col items-center justify-evenly w-full md:w-1/2 bg-white px-3 overflow-y-scroll py-5 custom-scroll">
            <div class="space-y-6 w-full px-10 relative">
                <div class="text">
                    <h1 class="text-2xl text-center my-1 ">
                        {{ __('Officer Register') }}
                    </h1>
                </div>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('officer.register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class=" !rounded-none !text-black block mt-1 w-full !bg-white custom-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class=" !rounded-none !text-black block mt-1 w-full !bg-white custom-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="my-4">
                        <x-input-label for="role_id" :value="__('Role')" />
                        <select name="role_id" id="role_id" class="w-full px-3 py-2 border-b-2 border-gray-300 focus:border-[#800000] transition-all duration-300 ease-in-out appearance-none bg-transparent pr-10 rounded-none" required>
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                @if($role->isAvailable()) <!-- Ensure only available roles are shown -->
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class=" !rounded-none !text-black block mt-1 w-full !bg-white custom-input"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class=" !rounded-none !text-black block mt-1 w-full !bg-white custom-input"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('officer.login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
                    
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
        border: none;
        border-bottom: 2px solid #800000; 
        background-color: white; 
        outline: none; 
        position: relative; 
        padding: 8px 0;
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        border-bottom-color: #fc4646;
    }


    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background-color: #f0f0f0;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #800000;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #660000;
    }

    ::-webkit-scrollbar-corner {
        background-color: transparent;
    }

    .custom-scroll::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background-color: #f0f0f0;
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background-color: #800000;
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background-color: #660000;
    }
</style>


</body>
</html>
