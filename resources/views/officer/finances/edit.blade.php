<x-officer-app-layout>

@section('content')
    <h1>Edit Finance Entry</h1>

    <form action="{{ route('finances.update', $finance->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="user_id">Student</label>
            <select name="user_id" id="user_id" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $finance->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="fee_name">Fee Name</label>
            <input type="text" name="fee_name" id="fee_name" value="{{ $finance->fee_name }}" required>
        </div>

        <div>
            <label for="amount">Amount</label>
            <input type="number" step="0.01" name="amount" id="amount" value="{{ $finance->amount }}" required>
        </div>

        <div>
            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="Paid" {{ $finance->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Not Paid" {{ $finance->status == 'Not Paid' ? 'selected' : '' }}>Not Paid</option>
            </select>
        </div>

        <button type="submit">Update</button>
    </form>
</x-officer-app-layout>
