@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: auto; padding-top: 20px; background-color: white; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border: 1px solid #ddd;">
    <h2 style="color: #5C0E0F; text-align: center; margin-bottom: 20px;">Finance Details</h2>

    <!-- User Information -->
    <div style="margin-bottom: 20px;">
        <h3 style="color: #5C0E0F;">Student Information</h3>
        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        <p><strong>School ID:</strong> {{ Auth::user()->school_id }}</p>
    </div>

    <!-- Finance Details -->
    <div style="margin-bottom: 20px;">
        <h3 style="color: #5C0E0F;">Finance Details</h3>
        <p><strong>Fee Name:</strong> {{ $finance->fee->name }}</p>
        <p><strong>Amount:</strong> {{ $finance->default_amount }}</p>
        <p><strong>Status:</strong> {{ $finance->status }}</p>
        <p><strong>Description:</strong> {{ $finance->description }}</p>
        <p><strong>Date:</strong> {{ $finance->created_at->format('F j, Y, g:i a') }}</p> <!-- Display the date and time -->
    </div>

    <!-- Print and Download Buttons -->
    @if($finance->status === 'Paid')
        <div style="text-align: center; margin-top: 20px;">
            <button onclick="printReceipt()" style="background-color: #5C0E0F; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; margin-right: 10px;">Print Receipt</button>
            <button onclick="downloadReceipt()" style="background-color: #5C0E0F; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer;">Download Receipt</button>
        </div>
    @endif
</div>

@section('scripts')
<script>
    function printReceipt() {
        window.print();
    }

    function downloadReceipt() {
        var element = document.querySelector('.container');
        var opt = {
            margin:       1,
            filename:     'receipt.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(element).set(opt).save();
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
@endsection
@endsection
