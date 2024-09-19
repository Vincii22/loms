<x-officer-app-layout>

    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
            {{ __('Officer') }} / 
            <a class="font-semibold text-gray-800 leading-tight hover:underline" href="{{ route('activities.index') }}">STUDENT LISTS /</a>
            <a href="" class="font-semibold text-indigo-600 uppercase">Edit Activity</a>
        </a>
    </x-slot>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="">
        <div class="flex justify-between">
            <div class="w-full pr-5 bg-white rounded-lg shadow-md p-6 mr-5 h-auto">
                <form action="{{ route('activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"  class="block mt-1 w-full !bg-white !text-black" value="{{ old('name', $activity->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description"  class="block mt-1 w-full !bg-white !text-black">{{ old('description', $activity->description) }}</textarea>
                    </div>

                    <div class="flex gap-4 mb-3">
                        <div class="mb-3 w-full">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="datetime-local" name="start_time" id="start_time"  class="block mt-1 w-full !bg-white !text-black" value="{{ old('start_time', $activity->start_time->format('Y-m-d\TH:i')) }}" required>
                        </div>

                        <div class="mb-3 w-full">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="datetime-local" name="end_time" id="end_time"  class="block mt-1 w-full !bg-white !text-black" value="{{ old('end_time', $activity->end_time ? $activity->end_time->format('Y-m-d\TH:i') : '') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" id="location"  class="block mt-1 w-full !bg-white !text-black" value="{{ old('location', $activity->location) }}">
                    </div>

                    <div class="flex gap-4 mb-3">
                        <div class="mb-3 w-full">
                            <label for="semester_id" class="form-label">Semester</label>
                            <select name="semester_id" id="semester_id"  class="block mt-1 w-full !bg-white !text-black">
                                <option value="">Select Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ old('semester_id', $activity->semester_id) == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 w-full">
                            <label for="school_year" class="form-label">School Year</label>
                            <input type="text" name="school_year" id="school_year"  class="block mt-1 w-full !bg-white !text-black" value="{{ old('school_year', $activity->school_year) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image"  class="block mt-1 w-full !bg-white !text-black">
                        @if($activity->image)
                            <img src="{{ Storage::url('images/' . $activity->image) }}" alt="Activity Image" style="width: 150px; margin-top: 10px;">
                        @endif
                    </div>
                    <div class="flex items-center justify-center mt-4 text-center">
                        <button type="submit" class="ml-4 !bg-[maroon] hover:!bg-[#b90000] !text-white font-bold py-2 px-16 rounded transition duration-300 ease-in-out">Update Activity</button>
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
    @endsection

    </x-officer-app-layout>
