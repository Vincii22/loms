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
        <div class="bg-[#5C0E0F] text-white p-8 lg:ml-4 rounded-3xl h-[63%] w-[45%] md:w-[60%] lg:w-[30%] flex items-center justify-center mr-20"> <!-- Added margin-right -->
            <div class="space-y-6">
                <h1 class="text-3xl font-bold mb-6 text-center">Login</h1>
                @if (Route::has('login'))
                <nav class="space-y-4 text-center">
                    @auth('web')
                        <a href="{{ url('/dashboard') }}" class="block text-lg bg-white text-[#5C0E0F] px-4 py-2 rounded-md hover:bg-gray-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block text-lg bg-white text-[#5C0E0F] px-4 py-2 rounded-md hover:bg-gray-200">Login as Student</a>
                        <span class="block text-lg my-2">or</span>
                        <a href="{{ route('officer.login') }}" class="block text-lg bg-white text-[#5C0E0F] px-4 py-2 rounded-md hover:bg-gray-200">Login as Officer</a>
                    @endauth
                </nav>
                @endif
            </div>
        </div>

    </div>
</body>
</html>
