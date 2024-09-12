<x-officer-app-layout>

@section('content')
<div class="container">
    <h1>Student Report</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date of Admission</th>
                <th>Class</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->date_of_admission }}</td>
                <td>{{ $student->class }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
</x-officer-app-layout>
