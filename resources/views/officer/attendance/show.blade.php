<x-officer-app-layout>
    @section('content')
    <div class="container mx-auto mt-4 p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Attendance Details</h1>

        <!-- Display attendance details -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">Attendance Information</h2>
            <p><strong>Student ID:</strong> {{ $attendance->user->school_id }}</p>
            <p><strong>Student Name:</strong> {{ $attendance->user->name }}</p>
            <p><strong>Activity:</strong> {{ $attendance->activity->name }}</p>
            <p><strong>Time In:</strong> {{ $attendance->time_in }}</p>
            <p><strong>Time Out:</strong> {{ $attendance->time_out }}</p>
            <p><strong>Status:</strong> {{ $attendance->status }}</p>
        </div>

        <!-- Modal -->
        <div id="student-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                <h2 class="text-xl font-bold mb-4" id="student-name"></h2>
                <img id="student-image" src="" alt="Student Image" class="w-24 h-24 mb-4">
                <p><strong>Course:</strong> <span id="student-course"></span></p>
                <p><strong>Year:</strong> <span id="student-year"></span></p>
                <p><strong>Organization:</strong> <span id="student-organization"></span></p>
                <p><strong>School ID:</strong> <span id="student-school-id"></span></p>
                <p><strong>Barcode:</strong> <span id="student-barcode"></span></p>
                <button id="modal-close" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Close</button>
            </div>
        </div>

        <!-- JavaScript to handle the modal -->
        <script>
            // Display modal with student data
            document.addEventListener('DOMContentLoaded', function() {
                const studentModal = document.getElementById('student-modal');
                const modalClose = document.getElementById('modal-close');
                const studentData = @json($attendance);

                // Populate modal with data
                document.getElementById('student-name').textContent = studentData.user.name;
                document.getElementById('student-image').src = studentData.user.image;
                document.getElementById('student-course').textContent = studentData.user.course.name;
                document.getElementById('student-year').textContent = studentData.user.year.name;
                document.getElementById('student-organization').textContent = studentData.user.organization.name;
                document.getElementById('student-school-id').textContent = studentData.user.school_id;
                document.getElementById('student-barcode').textContent = studentData.user.school_id; // Assuming barcode is same as school ID

                // Show the modal
                studentModal.classList.remove('hidden');

                // Close the modal
                modalClose.addEventListener('click', function() {
                    studentModal.classList.add('hidden');
                });
            });
        </script>

    </div>
    @endsection
</x-officer-app-layout>
