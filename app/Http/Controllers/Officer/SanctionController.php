<?php

namespace App\Http\Controllers\Officer;
use App\Models\Sanction;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Finance;
use App\Models\Semester;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SanctionController extends Controller
{
    public function index(Request $request)
    {
        $searchName = $request->input('search_name');
        $searchSchoolId = $request->input('search_school_id');
        $filterType = $request->input('filter_type');
        $filterSemester = $request->input('filter_semester');
        $filterSchoolYear = $request->input('filter_school_year');

        // Fetch available semesters and school years
        $semesters = Semester::all(); // Adjust if necessary
        $schoolYears = Sanction::distinct()->pluck('school_year'); // Adjust as needed

        $sanctions = Sanction::with('student')
            ->when($searchName, function ($query, $searchName) {
                return $query->whereHas('student', function ($query) use ($searchName) {
                    $query->where('name', 'like', '%' . $searchName . '%');
                });
            })
            ->when($searchSchoolId, function ($query, $searchSchoolId) {
                return $query->whereHas('student', function ($query) use ($searchSchoolId) {
                    $query->where('school_id', 'like', '%' . $searchSchoolId . '%');
                });
            })
            ->when($filterType, function ($query, $filterType) {
                return $query->where('type', $filterType);
            })
            ->when($filterSemester, function ($query, $filterSemester) {
                return $query->where('semester_id', $filterSemester);
            })
            ->when($filterSchoolYear, function ($query, $filterSchoolYear) {
                return $query->where('school_year', $filterSchoolYear);
            })
            ->paginate();

        $this->checkSanctions();
        $sanctionTypes = Sanction::distinct()->pluck('type');

        return view('officer.sanctions.index', compact('sanctions', 'sanctionTypes', 'semesters', 'schoolYears'));
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
            'resolved' => 'nullable|boolean',
        ]);

        $sanction->update([
            'fine_amount' => $request->input('fine_amount'),
            'required_action' => $request->input('required_action'),
            'resolved' => $request->has('resolved') ? true : false,
        ]);

        // Update clearance status after sanction update
        $user = $sanction->student;
        $user->updateClearanceStatus();

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
        Log::info('Running checkSanctions...');

        // Check for unpaid fees and create sanctions
        User::whereHas('finances', function ($query) {
            $query->where('status', 'Not Paid');
        })->chunk(100, function ($students) {
            foreach ($students as $student) {
                $unpaidFees = $student->finances->where('status', 'Not Paid');

                foreach ($unpaidFees as $fee) {
                    $feeName = optional($fee->fee)->name ?? 'Unknown Fee';

                    // Check if a sanction for this fee already exists
                    $existingSanction = Sanction::where([
                        ['student_id', $student->id],
                        ['type', "Unpaid Fees - $feeName"]
                    ])->first();

                    if (!$existingSanction) {
                        // Fetch semester_id and school_year from the related fee
                        $semesterId = optional($fee->fee)->semester_id;
                        $schoolYear = optional($fee->fee)->school_year;

                        Sanction::create([
                            'student_id' => $student->id,
                            'type' => "Unpaid Fees - $feeName",
                            'fine_amount' => 100,
                            'semester_id' => $semesterId,  // Add semester_id
                            'school_year' => $schoolYear,  // Add school_year
                            'resolved' => false,
                        ]);

                        // Ensure the clearance record exists
                        $clearance = $student->clearance()->first();
                        if ($clearance) {
                            $clearance->status = 'not cleared';
                            $clearance->save();
                        } else {
                            $student->clearance()->create(['status' => 'not cleared']);
                        }
                    }
                }
            }
        });

        // Check for absences and create sanctions
        User::whereHas('attendances', function ($query) {
            $query->where('status', 'absent');
        })->chunk(100, function ($studentsAbsent) {
            foreach ($studentsAbsent as $student) {
                $attendance = $student->attendances()->latest()->first();

                if ($attendance) {
                    $activityName = optional($attendance->activity)->name ?? 'Unknown Activity';

                    // Check if a sanction for this attendance already exists
                    $existingSanction = Sanction::where([
                        ['student_id', $student->id],
                        ['type', "Absence from $activityName"]
                    ])->first();

                    if (!$existingSanction) {
                        // Fetch semester_id and school_year from the related activity
                        $semesterId = optional($attendance->activity)->semester_id;
                        $schoolYear = optional($attendance->activity)->school_year;

                        Sanction::create([
                            'student_id' => $student->id,
                            'type' => "Absence from $activityName",
                            'description' => 'Absent from mandatory activity',
                            'fine_amount' => 50,
                            'semester_id' => $semesterId,  // Add semester_id
                            'school_year' => $schoolYear,  // Add school_year
                            'resolved' => false,
                        ]);

                        // Ensure the clearance record exists
                        $clearance = $student->clearance()->first();
                        if ($clearance) {
                            $clearance->status = 'not cleared';
                            $clearance->save();
                        } else {
                            $student->clearance()->create(['status' => 'not cleared']);
                        }
                    }
                }
            }
        });
    }

    public function deleteSanction($sanctionId)
    {
    $sanction = Sanction::findOrFail($sanctionId);
    $user = $sanction->student; // Use student relation or user if that's how it's defined

    // Delete the sanction
    $sanction->delete();

    // Update clearance status after deleting the sanction
    $user->updateClearanceStatus();

    return redirect()->back()->with('success', 'Sanction deleted and clearance status updated successfully!');
    }


}
