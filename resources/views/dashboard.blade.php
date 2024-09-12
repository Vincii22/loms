<x-app-layout>
    <x-slot name="header">
    <!-- {{ __("You're logged in!") }} -->

        <header class="bg-white shadow mb-4 px-5 py-5 rounded-[10px]">
            <div class="flex flex-col sm:flex-row justify-between items-center ">
                
                <h2 class="font-semibold text-xl !text-[#5C0E0F] dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <nav class="mt-4 sm:mt-0">
                    <ul class="flex space-x-4">
                        <li>
                            <a href="{{ route('finance.index') }}" class="text-blue-500 hover:underline">
                                My Financial Status
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

    <div class=" shadow mb-4 px-5 py-5 rounded-[10px]" style=" background: linear-gradient(to right, #c43e3e 20%, #5C0E0F);">
    <!-- <div class=" shadow mb-4 px-5 py-5 rounded-[10px]" style=" background-image: linear-gradient(to right, #ffffff, #f0e1f9, #f0c0e7, #f69cc6, #f87698, #e96079, #d84b59, #c4383a, #a92d2f, #8e2324, #751819, #5c0e0f);"> -->
        <div class="flex justify-between px-10 text-white">
            <div class="">
                <div class="flex">
                    <h1 class="mr-2">Welcome,</h1>
                    <div class="text-transform: uppercase">{{ Auth::user()->name }}</div>
                </div>
                <div class="">
                    <h2 class="w-[50rem] mt-8">
                        
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, repellendus? Ut sed commodi modi quidem est perferendis amet. Eligendi eaque laboriosam esse?
                    </h2>
                </div>
            </div>
            <div class="">
                <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="block h-[120px] w-auto fill-current">
            </div>
        </div>
    </div>


    <div class="bg-white shadow mb-4 px-5 py-2 rounded-[10px] ">
            <div class="">
                    <div class="px-6 !text-black dark:text-gray-100">

                        <h3 class="text-lg font-semibold mt-6 mb-4">Upcoming Activities</h3>
                        <ul>
                            @forelse ($activities as $activity)
                                <li class="mb-4 py-4 px-10 border rounded-lg bg-white shadow relative">
                                    <div class="flex justify-between">
                                        <div class="">
                                            <h4 class="text-xl font-bold text-[#5C0E0F]">{{ $activity->name }}</h4>
                                            <p class="text-[#5f5f5f] ">{{ $activity->description }}</p>
                                            <p class="text-sm text-black ">
                                                {{ $activity->start_time ? $activity->start_time->format('F j, Y, g:i a') : 'N/A' }}
                                                @if ($activity->end_time)
                                                    - {{ $activity->end_time->format('F j, Y, g:i a') }}
                                                @endif
                                            </p>
                                            <p class="text-sm text-black ">{{ $activity->location }}</p>
                                        </div>
                                        <div class="">
                                        <img src="{{ asset('images/licoes.png') }}" alt="Logo" class="mt-2 w-32 h-32 object-cover">

                                            @if ($activity->image)
                                                <!-- <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->name }}" class="mt-2 w-32 h-32 object-cover"> -->

                                            @endif
                                        </div>
                                    </div>
                                    
                                </li>
                            @empty
                                <p class="text-gray-600 dark:text-gray-400">No upcoming activities.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>


</x-slot>

</x-app-layout>
