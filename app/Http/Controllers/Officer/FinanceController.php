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
            'default_amount' => $fee->default_amount,
            'status' => $request->status,
        ]);

        return redirect()->route('finances.index')->with('success', 'Finance entry created successfully.');
    }

    public function edit(Finance $finance)
    {
        $officer = auth('officer')->user();
        $allowedRoles = ['Finance Officer', 'Deputy Finance', 'Auditor'];

        if (!in_array($officer->role->name, $allowedRoles)) {
            return redirect()->route('finances.index')->with('error', 'You are not allowed to Edit.');
        }

        $users = User::all();
        $fees = Fees::all();

        session()->flash('error', 'An error occurred while editing the finance record.');

        return view('officer.finances.edit', compact('finance', 'users', 'fees', 'officer'));
    }

    public function update(Request $request, Finance $finance)
    {
        $officer = auth('officer')->user();
        $allowedRoles = ['Finance Officer', 'Deputy Finance', 'Auditor'];

        // Check if the officer has one of the allowed roles
        if (!in_array($officer->role->name, $allowedRoles)) {
            return redirect()->route('finances.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fee_id' => 'required|exists:fees,id',
            'status' => 'required|in:Paid,Not Paid',
        ]);

        $oldStatus = $finance->status;
        $finance->status = $request->input('status');
        $finance->officer_id = auth('officer')->user()->id;
        $finance->save();

        // Handle status change
        if ($oldStatus === 'Not Paid' && $finance->status === 'Paid') {
            $this->updateSanctionsAndClearanceForPaidStatus($finance->user_id, $finance->fee_id);
        } elseif ($oldStatus === 'Paid' && $finance->status === 'Not Paid') {
            $this->createSanctionForUnpaidStatus($finance->user_id);
        } elseif ($finance->status === 'Not Paid') {
            $this->checkAndSanctionUnpaidStudents();
        }

        return redirect()->route('finances.index')->with('success', 'Finance entry updated successfully.');
    }

    protected function updateSanctionsAndClearanceForPaidStatus($studentId, $feeId)
    {
       // Resolve only sanctions for the specific fee being paid
        Sanction::where('student_id', $studentId)
        ->where('type', 'Unpaid Fees - ' . Fees::findOrFail($feeId)->name) // Specific fee
        ->where('resolved', 'not resolved')
        ->update(['resolved' => 'resolved']);
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
            $fineAmount = $unpaidFeesCount * 100;

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
        Log::info('Deleting Finance ID: ' . $finance->id);

        $deletedSanctionsCount = Sanction::where('student_id', $finance->user_id)
            ->where('type', 'LIKE', 'Unpaid Fees%')
            ->where('resolved', false)
            ->whereHas('fee', function ($query) use ($finance) {
                $query->where('id', $finance->fee_id);
            })
            ->delete();

        Log::info('Number of sanctions deleted: ' . $deletedSanctionsCount);

        $finance->delete();

        return redirect()->route('finances.index')->with('success', 'Finance entry deleted successfully.');
    }

    protected function checkAndSanctionUnpaidStudents()
    {
        $studentsWithUnpaidFees = User::whereHas('finances', function ($query) {
            $query->where('status', 'Not Paid');
        })->get();

        foreach ($studentsWithUnpaidFees as $student) {
            $unpaidFees = $student->finances->where('status', 'Not Paid');

            $existingSanction = Sanction::where('student_id', $student->id)
                ->where('type', 'finance')
                ->where('resolved', false)
                ->first();

            if (!$existingSanction) {
                $fineAmount = $unpaidFees->count() * 100;

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
