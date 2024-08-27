@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clearance Report</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clearances as $clearance)
            <tr>
                <td>{{ $clearance->id }}</td>
                <td>{{ $clearance->date }}</td>
                <td>{{ $clearance->status }}</td>
                <td>{{ $clearance->remarks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
