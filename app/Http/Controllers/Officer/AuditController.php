<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fees;
use App\Models\User;
use App\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
       // Get all fees
    $fees = Fees::all();

    // If a fee is selected, calculate the total amount
    $selectedFeeId = $request->input('fee_id');
    $totalAmount = 0;

    if ($selectedFeeId) {
        $totalAmount = Audit::calculateTotalAmount($selectedFeeId);
    }

    return view('officer.audit.index', compact('fees', 'totalAmount', 'selectedFeeId'));
    }
}
