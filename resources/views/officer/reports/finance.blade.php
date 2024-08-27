@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Finance Report</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($finances as $finance)
            <tr>
                <td>{{ $finance->id }}</td>
                <td>{{ $finance->date }}</td>
                <td>{{ $finance->amount }}</td>
                <td>{{ $finance->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
