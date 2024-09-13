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

                    <!-- Username -->
                    <div class="mb-4">
                        <input id="username" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-red-500 outline-none" 
                        type="text" name="username" placeholder="Username" required autofocus autocomplete="username" />
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <input id="password" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-red-500 outline-none" 
                        type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                    </div>

                    <!-- Sign In Button -->
                    <div class="mb-4">
                        <button class="w-full bg-[#5c0e0f] text-white py-2 rounded-md hover:bg-[#c43e3e] transition duration-300">
                            Sign In
                        </button>
                    </div>

                    <!-- Sign Up Link -->
                    <div class="text-center mt-10">
                        <p class="text-sm text-gray-600">Don't have an account? 
                            <a href="{{ route('register') }}" class="text-red-500 hover:underline">Sign Up Now</a>
                        </p>
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

