<?php

namespace App\Http\Controllers\Officer;

use App\Models\Finance;
use App\Models\User;
use App\Models\Fees;
use App\Models\Sanction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    // Other methods related to officers

    // Finance-related methods
    public function index(Request $request)
    {
        $feeId = $request->query('fee_id');
        $financesQuery = Finance::with('user', 'fee');

        if ($feeId) {
            $financesQuery->where('fee_id', $feeId);
        }

        $finances = $financesQuery->get();
        $fees = Fees::all(); // Fetch all fees

        return view('officer.finances.index', compact('finances', 'fees'));
    }

    public function create()
    {
        $users = User::all();
        $fees = Fees::all(); // Fetch all fees
        return view('officer.finances.create', compact('users', 'fees'));
    }

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'fee_id' => 'required|exists:fees,id',
        'status' => 'required|in:Paid,Not Paid',
    ]);

    // Retrieve the fee details
    $fee = Fees::findOrFail($request->fee_id);

    // Create a new finance entry
    Finance::create([
        'user_id' => $request->user_id,
        'fee_id' => $request->fee_id,
        'default_amount' => $fee->default_amount, // Ensure this matches the schema
        'status' => $request->status,
    ]);

    return redirect()->route('finances.index')->with('success', 'Finance entry created successfully.');
}


    public function edit(Finance $finance)
    {
        $users = User::all();
        $fees = Fees::all();
        return view('officer.finances.edit', compact('finance', 'users', 'fees'));
    }

    public function update(Request $request, Finance $finance)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fee_id' => 'required|exists:fees,id',
            'status' => 'required|in:Paid,Not Paid',
        ]);

        $finance->update($request->all());

        return redirect()->route('officer.finances.index')->with('success', 'Finance entry updated successfully.');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();
        return redirect()->route('officer.finances.index')->with('success', 'Finance entry deleted successfully.');
    }


    public function updatePaymentStatus(Request $request)
    {
        // Update payment status logic here...

        // After updating payment, check for unpaid fees and add sanctions
        $this->checkAndSanctionUnpaidStudents();
    }

    protected function checkAndSanctionUnpaidStudents()
    {
        $unpaidStudents = User::whereHas('fees', function ($query) {
            $query->where('status', 'unpaid');
        })->get();

        foreach ($unpaidStudents as $student) {
            // Check if the student is already sanctioned for unpaid fees
            $existingSanction = Sanction::where('student_id', $student->id)
                ->where('type', 'finance')
                ->where('resolved', false)
                ->first();

            if (!$existingSanction) {
                Sanction::create([
                    'student_id' => $student->id,
                    'type' => 'finance',
                    'description' => 'Unpaid fees',
                    'fine_amount' => 100, // Example fine amount
                    'required_action' => 'Pay outstanding fees', // Required action
                    'resolved' => false,
                ]);
            }
        }
    }
}

