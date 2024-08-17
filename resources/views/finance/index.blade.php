@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: auto; padding-top: 20px;">
    <h2 style="color: #5C0E0F; text-align: center; margin-bottom: 20px;">My Financial Status</h2>
    <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 20px; background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <thead style="background-color: #5C0E0F; color: white;">
            <tr>
                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Fee Name</th>
                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Amount</th>
                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Status</th>
                <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($finances as $finance)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $finance->fee->name }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $finance->fee->default_amount }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $finance->status }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                        <a href="{{ route('finance.show', $finance->id) }}" style="color: #5C0E0F; text-decoration: none;">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
