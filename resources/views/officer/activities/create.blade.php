<x-officer-app-layout>

    @section('content')
    <div class="container mx-auto py-3">
        <x-slot name="header">
            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                {{ __('Officer') }} /
                <a href="{{ route('activities.index') }}" class="text-black hover:underline">ACTIVITIES /</a>
                <a href="{{ route('activities.create') }}" class="text-indigo-600 uppercase">Create New Activity</a>
            </h2>
        </x-slot>

        <div class="">
            <div class="flex justify-between">
                <div class="w-full pr-5 bg-white rounded-lg shadow-md p-6 mr-5 h-auto">
                    <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" id="name" name="name" class="form-input mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Description</label>
                            <textarea id="description" name="description" class="form-textarea mt-1 block w-full"></textarea>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-full">
                                <label for="start_time" class="block text-gray-700">Start of Time In</label>
                                <input type="datetime-local" id="start_time" name="start_time" class="form-input mt-1 block w-full" required>
                            </div>
                            <div class="w-full">
                                <label for="end_time" class="block text-gray-700">Start of Time Out</label>
                                <input type="datetime-local" id="end_time" name="end_time" class="form-input mt-1 block w-full">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="location" class="block text-gray-700">Location</label>
                            <input type="text" id="location" name="location" class="form-input mt-1 block w-full">
                        </div>
                        <div class="flex gap-4 mt-4">
                            <div class="w-full">
                                <label for="school_year" class="block text-gray-700">School Year</label>
                                <input type="text" id="school_year" name="school_year" class="form-input mt-1 block w-full">
                            </div>
                            <div class="w-full">
                            <label for="semester_id" class="block text-gray-700">Semester</label>
                            <select id="semester_id" name="semester_id" class="form-select mt-1 block w-full">
                                <option value="">Select Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        
                        <div class="mb-4 mt-5">
                            <label for="image">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="flex items-center justify-center">
                            <button type="submit" class="bg-[maroon] hover:bg-[maroon] text-white font-bold py-2 px-4 rounded w-1/4 transition duration-300 ease-in-out">Create Activity</button>
                        </div>
                    </form>
                </div>
                <div class="hidden relative md:flex md:w-1/4 bg-cover bg-no-repeat bg-center" style="background-image: url('{{ asset('images/a22bdfe2-9782-4e40-ac24-750136e7d7b9.jpeg') }}');">
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
        </div>
    </div>
    @endsection

    </x-officer-app-layout>
