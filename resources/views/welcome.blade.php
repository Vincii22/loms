<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center overflow-hidden">
   
<div class="design"></div>
    <div style="" class="h-[550px] flex overflow-hidden z-10 relative">
        <!-- Left Section (Login Form) -->
        <div class="flex flex-col items-center justify-evenly w-full md:w-1/2 bg-white px-3 ">
            <div class="space-y-6 w-full px-10">
                <h1 class="text-3xl font-bold mb-6 text-center pb-10">Welcome</h1>
                @if (Route::has('login'))
                <nav class="space-y-2 text-center">
                    @auth('web')
                        <a href="{{ url('/dashboard') }}" class="block text-lg bg-[#5C0E0F] text-[white] px-4 py-2 rounded-md hover:bg-[#792124]">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block text-lg bg-[#5C0E0F] text-[white] px-4 py-2 rounded-md hover:bg-[#792124]">Login as Student</a>
                        <span class="block text-lg my-2 !mb-3">or</span>
                        <a href="{{ route('officer.login') }}" class="block text-lg bg-[#5C0E0F] text-[white] px-4 py-2 rounded-md hover:bg-[#792124]">Login as Officer</a>
                    @endauth
                </nav>
                @endif
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
        <div class="hidden md:flex md:w-1/1 bg-cover bg-no-repeat bg-center" style="background-image: url('{{ asset('images/bfe6d0c4-dfbf-4c0c-8c54-1db80dd644ba.jpeg') }}');">
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
</style>
</body>
</html>
