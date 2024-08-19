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
                <label for="fee_id">Fee Name</label>
                <input type="text" id="fee_name" value="{{ $finance->fee->name }}" readonly>
                <input type="hidden" name="fee_id" id="fee_id" value="{{ $finance->fee_id }}">
            </div>

            <div>
                <label for="amount">Amount</label>
                <input type="text" id="amount" value="{{ $finance->default_amount }}" readonly>
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
