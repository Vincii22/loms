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
use Illuminate\Support\Facades\Log;

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

    $financesQuery = Finance::with('user', 'fee')
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
        });

    $finances = $feeId ? $financesQuery->paginate(10) : collect();

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

        $oldStatus = $finance->status;
        $finance->status = $request->input('status');
        $finance->save();

        // Handle status change
        if ($oldStatus === 'Not Paid' && $finance->status === 'Paid') {
            $this->removeSanctionsForPaidStatus($finance->user_id);
        } elseif ($oldStatus === 'Paid' && $finance->status === 'Not Paid') {
            $this->createSanctionForUnpaidStatus($finance->user_id);
        } elseif ($finance->status === 'Not Paid') {
            $this->checkAndSanctionUnpaidStudents();
        }

        return redirect()->route('finances.index')->with('success', 'Finance entry updated successfully.');
    }

    protected function createSanctionForUnpaidStatus($studentId)
{
    Log::info("Creating sanction for student ID: $studentId");

    $existingSanction = Sanction::where('student_id', $studentId)
                                ->where('type', 'finance')
                                ->where('resolved', false)
                                ->first();

    if (!$existingSanction) {
        $unpaidFeesCount = User::findOrFail($studentId)->finances()->where('status', 'Not Paid')->count();
        $fineAmount = $unpaidFeesCount * 100; // Example fine calculation based on number of unpaid fees

        Sanction::create([
            'student_id' => $studentId,
            'type' => 'finance',
            'fine_amount' => $fineAmount,
            'required_action' => 'Pay outstanding fees',
            'resolved' => false,
        ]);

        Log::info('Sanction created:', Sanction::where('student_id', $studentId)->latest()->first()->toArray());
    }
}
public function destroy(Finance $finance)
{
         // Log the finance being deleted
    Log::info('Deleting Finance ID: ' . $finance->id);

    // Find and delete related sanctions
    $deletedSanctionsCount = Sanction::where('student_id', $finance->user_id)
        ->where('type', 'LIKE', 'Unpaid Fees%')
        ->where('resolved', false)
        ->whereHas('fee', function ($query) use ($finance) {
            $query->where('id', $finance->fee_id);
        })
        ->delete();

    Log::info('Number of sanctions deleted: ' . $deletedSanctionsCount);

    // Delete the finance record
    $finance->delete();

    return redirect()->route('finances.index')->with('success', 'Finance entry deleted successfully.');

}

    public function updatePaymentStatus(Request $request)
    {
        // Validate the request
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'fee_id' => 'required|exists:fees,id',
            'status' => 'required|in:Paid,Not Paid', // Ensure this matches the database status
        ]);

        // Retrieve the finance entry and update its status
        $finance = Finance::where('user_id', $request->student_id)
                          ->where('fee_id', $request->fee_id)
                          ->firstOrFail();

        $oldStatus = $finance->status;
        $finance->status = $request->status;
        $finance->save();

        // Handle sanctions based on the new status
        if ($oldStatus === 'Not Paid' && $finance->status === 'Paid') {
            $this->removeSanctionsForPaidStatus($request->student_id);
        } elseif ($finance->status === 'Not Paid') {
            $this->checkAndSanctionUnpaidStudents();
        }

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }

    protected function removeSanctionsForPaidStatus($studentId)
    {
           // Log removal attempt
           Log::info("Removing sanctions for student ID: $studentId");

           // Remove all sanctions related to unpaid fees for the student
           Sanction::where('student_id', $studentId)
               ->where('type', 'LIKE', 'Unpaid Fees%')
               ->where('resolved', false)
               ->delete();

           // Log the removal
           Log::info('Sanctions removed:', Sanction::where('student_id', $studentId)
                                                     ->where('type', 'LIKE', 'Unpaid Fees%')
                                                     ->where('resolved', false)
                                                     ->get()
                                                     ->toArray());
    }

    protected function checkAndSanctionUnpaidStudents()
    {
        // Fetch students with unpaid fees
    $studentsWithUnpaidFees = User::whereHas('finances', function ($query) {
        $query->where('status', 'Not Paid'); // Updated to match database status
    })->get();

    foreach ($studentsWithUnpaidFees as $student) {
        // Fetch unpaid fees for the student
        $unpaidFees = $student->finances->where('status', 'Not Paid'); // Updated to match database status

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
                'fine_amount' => $fineAmount,
                'required_action' => 'Pay outstanding fees',
                'resolved' => false,
            ]);
        }
    }
}
}
