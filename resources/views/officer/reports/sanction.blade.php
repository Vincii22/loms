<x-officer-app-layout>
    @section('content')
    <div class="container">
        <h1>Sanction Report</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('reports.sanction') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="semester">Semester</label>
                    <select name="semester" id="semester" class="form-control">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $id => $name)
                            <option value="{{ $id }}" {{ request('semester') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="school_year">School Year</label>
                    <select name="school_year" id="school_year" class="form-control">
                        <option value="">All School Years</option>
                        @foreach($schoolYears as $year)
                            <option value="{{ $year }}" {{ request('school_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="resolved">Status</label>
                    <select name="resolved" id="resolved" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="resolved" {{ request('resolved') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="not resolved" {{ request('resolved') == 'not resolved' ? 'selected' : '' }}>Not Resolved</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <!-- Sanctions Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Semester</th>
                    <th>School Year</th>
                    <th>Fine Amount</th>
                    <th>Required Action</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sanctions as $sanction)
                    <tr>
                        <td>{{ $sanction->id }}</td>
                        <td>{{ $sanction->student->name }}</td>
                        <td>{{ $sanction->semester->name }}</td>
                        <td>{{ $sanction->school_year }}</td>
                        <td>{{ $sanction->fine_amount }}</td>
                        <td>{{ $sanction->required_action }}</td>
                        <td>{{ ucfirst($sanction->resolved) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No sanctions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $sanctions->links() }}
        </div>
    </div>
@endsection
</x-officer-app-layout>
