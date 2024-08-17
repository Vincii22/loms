<x-officer-app-layout>

    @section('content')
    <div class="container">
        <h1>Edit Clearance Status</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('clearance.update', $clearance->user_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="eligible" {{ $clearance->status === 'eligible' ? 'selected' : '' }}>Eligible</option>
                    <option value="not eligible" {{ $clearance->status === 'not eligible' ? 'selected' : '' }}>Not Eligible</option>
                    <option value="cleared" {{ $clearance->status === 'cleared' ? 'selected' : '' }}>Cleared</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Status</button>
        </form>
    </div>
    @endsection


</x-officer-app-layout>
