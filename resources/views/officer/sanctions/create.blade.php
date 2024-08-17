<x-officer-app-layout>

@section('content')
<div class="container">
    <h1>Add Sanction</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sanctions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">Student</label>
            <select name="student_id" id="student_id" class="form-select">
                @foreach($Users as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="fine_amount" class="form-label">Fine Amount</label>
            <input type="number" step="0.01" name="fine_amount" id="fine_amount" class="form-control" value="{{ old('fine_amount') }}">
        </div>

        <div class="mb-3">
            <label for="required_action" class="form-label">Required Action</label>
            <textarea name="required_action" id="required_action" class="form-control">{{ old('required_action') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
</x-officer-app-layout>
