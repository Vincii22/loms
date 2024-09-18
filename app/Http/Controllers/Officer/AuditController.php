<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fees;
use App\Models\User;
use App\Models\Audit;
use App\Models\Finance;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        // Get all fees
        $fees = Fees::all();

        // Initialize variables
        $selectedFeeId = $request->input('fee_id');
        $totalAmount = 0;
        $details = [];
        $feeCollected = 0;
        $feeNotCollected = 0;

        if ($selectedFeeId) {
            $totalAmount = Audit::calculateTotalAmount($selectedFeeId);

            // Fetch detailed information including officer name
            $details = Finance::where('fee_id', $selectedFeeId)
                              ->with('officer') // Ensure 'officer' relationship is defined in the Finance model
                              ->get();

            // Calculate Fee Collected and Fee Not Collected
            $feeCollected = Finance::where('fee_id', $selectedFeeId)
                                   ->where('status', 'paid')
                                   ->sum('default_amount');

            $feeNotCollected = Finance::where('fee_id', $selectedFeeId)
                                      ->where('status', 'not paid')
                                      ->sum('default_amount');
        }

        // Calculate Target Budget
        $targetBudget = $feeCollected + $feeNotCollected;

        return view('officer.audit.index', compact('fees', 'totalAmount', 'selectedFeeId', 'details', 'feeCollected', 'feeNotCollected', 'targetBudget'));
    }

}
