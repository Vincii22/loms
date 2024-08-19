<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <h3 class="text-lg font-semibold mt-6 mb-4">Upcoming Activities</h3>
                    <ul>
                        @forelse ($activities as $activity)
                            <li class="mb-4 p-4 border rounded-lg bg-gray-50 dark:bg-gray-700">
                                <h4 class="text-xl font-bold">{{ $activity->name }}</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $activity->description }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                    {{ $activity->start_time ? $activity->start_time->format('F j, Y, g:i a') : 'N/A' }}
                                    @if ($activity->end_time)
                                        - {{ $activity->end_time->format('F j, Y, g:i a') }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-300">{{ $activity->location }}</p>
                                @if ($activity->image)
                                    <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->name }}" class="mt-2 w-32 h-32 object-cover">
                                @endif
                            </li>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No upcoming activities.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-slot>

</x-app-layout>
