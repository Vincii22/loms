{{-- resources/views/officer/audit/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Audit Summary</h1>

    <form action="{{ route('audit.index') }}" method="GET">
        <div class="form-group">
            <label for="fee_id">Select Fee:</label>
            <select name="fee_id" id="fee_id" class="form-control">
                <option value="">-- Select Fee --</option>
                @foreach($fees as $fee)
                    <option value="{{ $fee->id }}" {{ $selectedFeeId == $fee->id ? 'selected' : '' }}>
                        {{ $fee->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    @if($selectedFeeId)
        <h2>Summary for {{ $fees->find($selectedFeeId)->name }}</h2>
        <p>Total Amount: {{ $totalAmount }}</p>
    @else
        <p>Please select a fee to view the summary.</p>
    @endif
</div>
@endsection
