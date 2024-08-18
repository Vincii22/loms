<?php

namespace App\Http\Controllers\Officer;


use App\Models\Finance;
use App\Models\User;
use App\Models\Fees;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;
use App\Models\Sanction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    // Other methods related to officers

    // Finance-related methods
    public function index(Request $request)
    {
        $searchName = $request->input('search_name');
        $searchSchoolId = $request->input('search_school_id');
        $filterOrganization = $request->input('filter_organization');
        $filterCourse = $request->input('filter_course');
        $filterYear = $request->input('filter_year');
        $feeId = $request->input('fee_id');

        $finances = Finance::with('user', 'fee')
            ->when($searchName, function ($query, $searchName) {
                return $query->whereHas('user', function ($query) use ($searchName) {
                    $query->where('name', 'like', '%' . $searchName . '%');
                });
            })
            ->when($searchSchoolId, function ($query, $searchSchoolId) {
                return $query->whereHas('user', function ($query) use ($searchSchoolId) {
                    $query->where('school_id', 'like', '%' . $searchSchoolId . '%');
                });
            })
            ->when($filterOrganization, function ($query, $filterOrganization) {
                return $query->whereHas('user.organization', function ($query) use ($filterOrganization) {
                    $query->where('id', $filterOrganization);
                });
            })
            ->when($filterCourse, function ($query, $filterCourse) {
                return $query->whereHas('user.course', function ($query) use ($filterCourse) {
                    $query->where('id', $filterCourse);
                });
            })
            ->when($filterYear, function ($query, $filterYear) {
                return $query->whereHas('user.year', function ($query) use ($filterYear) {
                    $query->where('id', $filterYear);
                });
            })
            ->when($feeId, function ($query, $feeId) {
                return $query->where('fee_id', $feeId);
            })
            ->paginate(10);

        // Fetch all organizations, courses, years, and fees for filtering options
        $organizations = Organization::all();
        $courses = Course::all();
        $years = Year::all();
        $fees = Fees::all();

        return view('officer.finances.index', compact('finances', 'organizations', 'courses', 'years', 'fees'));
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
          // Validate the request
    $request->validate([
        'student_id' => 'required|exists:users,id',
        'fee_id' => 'required|exists:fees,id',
        'status' => 'required|in:paid,unpaid',
    ]);

    // Retrieve the fee based on the provided fee_id
    $fee = Fees::find($request->fee_id);

    // Update the payment status of the fee
    $fee->status = $request->status;
    $fee->save();

    // After updating payment, check for unpaid fees and add sanctions
    $this->checkAndSanctionUnpaidStudents();
    }

    protected function checkAndSanctionUnpaidStudents()
    {
        // Fetch students with unpaid fees
        $studentsWithUnpaidFees = User::whereHas('fees', function ($query) {
            $query->where('status', 'unpaid');
        })->get();

        foreach ($studentsWithUnpaidFees as $student) {
            // Fetch unpaid fees for the student
            $unpaidFees = $student->fees->where('status', 'unpaid');

            // Check if the student is already sanctioned for unpaid fees
            $existingSanction = Sanction::where('student_id', $student->id)
                ->where('type', 'finance')
                ->where('resolved', false)
                ->first();

            if (!$existingSanction) {
                $fineAmount = $unpaidFees->count() * 100; // Example fine calculation based on number of unpaid fees

                Sanction::create([
                    'student_id' => $student->id,
                    'type' => 'finance',
                    'description' => 'Unpaid fees',
                    'fine_amount' => $fineAmount,
                    'required_action' => 'Pay outstanding fees',
                    'resolved' => false,
                ]);
            }
        }
    }
}

