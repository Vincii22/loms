@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sanction Report</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sanctions as $sanction)
            <tr>
                <td>{{ $sanction->id }}</td>
                <td>{{ $sanction->date }}</td>
                <td>{{ $sanction->reason }}</td>
                <td>{{ $sanction->amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
