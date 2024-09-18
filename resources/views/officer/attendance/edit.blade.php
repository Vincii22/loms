<x-officer-app-layout>
    @section('content')
    <x-slot name="header">
        <a class="font-semibold text-lg text-gray-800 leading-tight" href="{{ route('officer.dashboard') }}">
            {{ __('Officer') }} / 
            <a class="font-semibold text-gray-800 leading-tight hover:underline" href="{{ route('attendance.index') }}">ATTENDANCE MANAGEMENT /</a>
            <a href="" class="font-semibold text-indigo-600 uppercase">Edit Attendance Record</a>
        </a>
    </x-slot>
    @if($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
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
                <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="student_id" class="block text-sm font-medium text-gray-700">Student</label>
                        <select name="student_id" id="student_id" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $attendance->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="activity_id" class="block text-sm font-medium text-gray-700">Activity</label>
                        <select name="activity_id" id="activity_id" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($activities as $activity)
                                <option value="{{ $activity->id }}" {{ $attendance->activity_id == $activity->id ? 'selected' : '' }}>
                                    {{ $activity->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="edit_type" class="block text-sm font-medium text-gray-700">Edit Time</label>
                        <select name="edit_type" id="edit_type" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="time_in" {{ old('edit_type', 'time_in') == 'time_in' ? 'selected' : '' }}>Time In</option>
                            <option value="time_out" {{ old('edit_type', 'time_out') == 'time_out' ? 'selected' : '' }}>Time Out</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="time_value" class="block text-sm font-medium text-gray-700">Time</label>
                        <input type="time" name="time_value" id="time_value" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Attendance</button>
                    <a href="{{ route('attendance.index', ['filter_activity' => $attendance->activity_id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editTypeSelect = document.getElementById('edit_type');
                const timeInput = document.getElementById('time_value');
                const now = new Date();

                // Get current time in the Philippines timezone (UTC+8)
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const currentTime = `${hours}:${minutes}`;

                function updateTimeValue() {
                    const selectedType = editTypeSelect.value;
                    if (selectedType === 'time_in') {
                        timeInput.value = "{{ old('time_value', $attendance->time_in) }}" || currentTime;
                    } else if (selectedType === 'time_out') {
                        timeInput.value = "{{ old('time_value', $attendance->time_out) }}" || currentTime;
                    }
                }

                editTypeSelect.addEventListener('change', updateTimeValue);

                // Set initial value based on default selection
                updateTimeValue();
            });
        </script>
    </div>
    @endsection
</x-officer-app-layout>
