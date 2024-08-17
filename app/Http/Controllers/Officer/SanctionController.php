<?php

namespace App\Http\Controllers\Officer;
use App\Models\Sanction;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Finance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SanctionController extends Controller
{
    public function index()
    {
        $this->checkSanctions();

        $sanctions = Sanction::with('student')->get(); // Use 'student' here
        return view('officer.sanctions.index', compact('sanctions'));
    }

    public function edit($id)
    {
        $sanction = Sanction::with('student')->findOrFail($id); // Fetch a single sanction with its related student
        return view('officer.sanctions.edit', ['sanction' => $sanction]);
    }

    public function update(Request $request, $id)
    {
        $sanction = Sanction::findOrFail($id);

        $request->validate([
            'fine_amount' => 'nullable|numeric|min:0',
            'required_action' => 'nullable|string|max:255',
            'resolved' => 'nullable|boolean', // This ensures 'resolved' is either true or false
        ]);

        $sanction->update([
            'fine_amount' => $request->input('fine_amount'),
            'required_action' => $request->input('required_action'),
            'resolved' => $request->has('resolved') ? true : false, // Ensure resolved is either true or false
        ]);

        return redirect()->route('sanctions.index')->with('success', 'Sanction updated successfully.');
    }
    public function destroy(Sanction $sanction)
    {
        $sanction->delete();

        return redirect()->route('sanctions.index')->with('success', 'Sanction deleted successfully.');
    }
    // Other methods...

    public function checkSanctions()
    {
        // Check for unpaid fees and create sanctions
        $usersWithUnpaidFees = User::whereHas('finances', function ($query) {
            $query->where('status', '!=', 'Paid'); // Ensure 'Paid' matches your enum value
        })->get();
        foreach ($usersWithUnpaidFees as $user) {
            $unpaidFees = Finance::where('user_id', $user->id)
                                 ->where('status', 'unpaid')
                                 ->get();

            foreach ($unpaidFees as $fee) {
                // Check if fee relationship is correctly accessed
                $feeRecord = $fee->fee;
                if ($feeRecord) {
                    $feeName = $feeRecord->name; // Access name attribute from fee relationship
                } else {
                    $feeName = 'Unknown Fee'; // Fallback if fee is null
                }

                // Create a sanction with detailed type including the fee name
                Sanction::firstOrCreate([
                    'student_id' => $user->id,
                    'type' => "Unpaid Fees - $feeName",
                    'description' => "Unpaid $feeName for the current term",
                    'fine_amount' => 100,
                    'resolved' => false,
                ]);
            }
        }

        // Check for absences and create sanctions
        $usersAbsent = User::whereHas('attendances', function ($query) {
            $query->where('status', 'absent');
        })->get();

        foreach ($usersAbsent as $user) {
            // Fetch the most recent attendance record for the user
            $attendance = Attendance::where('student_id', $user->id)
                ->latest() // Get the most recent attendance record
                ->first();

            if ($attendance) {
                $activityName = $attendance->activity->name; // Assuming the Attendance model has a relationship with Activity

                // Check if a sanction already exists for this user and activity
                $existingSanction = Sanction::where([
                    ['student_id', '=', $user->id],
                    ['type', '=', "Absence from $activityName"]
                ])->first();

                if (!$existingSanction) {
                    // Create a sanction only if it does not already exist
                    Sanction::create([
                        'student_id' => $user->id,
                        'type' => "Absence from $activityName", // Include activity name in the type
                        'description' => 'Absent from mandatory activity',
                        'fine_amount' => 50, // Example fine amount
                        'resolved' => false,
                    ]);
                }
            }
         }
}
}
