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
        $semesters = Semester::all();
        $schoolYears = Sanction::distinct()->pluck('school_year');

        Log::info('Filter Parameters:', [
            'searchName' => $searchName,
            'searchSchoolId' => $searchSchoolId,
            'filterType' => $filterType,
            'filterSemester' => $filterSemester,
            'filterSchoolYear' => $filterSchoolYear,
        ]);

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
        $sanction = Sanction::with('student')->findOrFail($id);
        return view('officer.sanctions.edit', ['sanction' => $sanction]);
    }

    public function update(Request $request, $id)
    {
        $sanction = Sanction::findOrFail($id);

        $request->validate([
            'fine_amount' => 'nullable|numeric|min:0',
            'required_action' => 'nullable|string|max:255',
            'resolved' => 'required|in:resolved,not resolved', // Ensure it's one of the ENUM values
        ]);

        $sanction->update([
            'fine_amount' => $request->input('fine_amount'),
            'required_action' => $request->input('required_action'),
            'resolved' => $request->input('resolved'), // Store the ENUM value
        ]);

        // Update clearance status
        $sanction->student->updateClearanceStatus();

        return redirect()->route('sanctions.index')->with('success', 'Sanction updated successfully.');
    }

    public function destroy(Sanction $sanction)
    {
        $sanction->delete();

        return redirect()->route('sanctions.index')->with('success', 'Sanction deleted successfully.');
    }

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
                    $semesterId = optional($fee->fee)->semester_id;
                    $schoolYear = optional($fee->fee)->school_year;

                    $existingSanction = Sanction::where([
                        ['student_id', $student->id],
                        ['type', "Unpaid Fees - $feeName"],
                        ['semester_id', $semesterId],
                        ['school_year', $schoolYear]
                    ])->first();

                    if (!$existingSanction) {
                        Sanction::create([
                            'student_id' => $student->id,
                            'type' => "Unpaid Fees - $feeName",
                            'fine_amount' => 100,
                            'semester_id' => $semesterId,
                            'school_year' => $schoolYear,
                            'resolved' => 'not resolved',
                        ]);

                        $student->clearance()->firstOrCreate(['status' => 'not cleared']);
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
                    $semesterId = optional($attendance->activity)->semester_id;
                    $schoolYear = optional($attendance->activity)->school_year;

                    $existingSanction = Sanction::where([
                        ['student_id', $student->id],
                        ['type', "Absence from $activityName"],
                        ['semester_id', $semesterId],
                        ['school_year', $schoolYear]
                    ])->first();

                    if (!$existingSanction) {
                        Sanction::create([
                            'student_id' => $student->id,
                            'type' => "Absence from $activityName",
                            'description' => 'Absent from mandatory activity',
                            'fine_amount' => 50,
                            'semester_id' => $semesterId,
                            'school_year' => $schoolYear,
                            'resolved' => 'not resolved',
                        ]);

                        $student->clearance()->firstOrCreate(['status' => 'not cleared']);
                    }
                }
            }
        });

        // Update sanctions to resolved based on Finance status updates
        User::whereHas('finances', function ($query) {
            $query->where('status', 'Paid');
        })->chunk(100, function ($students) {
            foreach ($students as $student) {
                $paidFees = $student->finances->where('status', 'Paid');

                foreach ($paidFees as $fee) {
                    $feeName = optional($fee->fee)->name ?? 'Unknown Fee';
                    $semesterId = optional($fee->fee)->semester_id;
                    $schoolYear = optional($fee->fee)->school_year;

                    $sanctions = Sanction::where([
                        ['student_id', $student->id],
                        ['type', "Unpaid Fees - $feeName"],
                        ['semester_id', $semesterId],
                        ['school_year', $schoolYear]
                    ])->where('resolved', 'not resolved')->get();

                    foreach ($sanctions as $sanction) {
                        $sanction->update(['resolved' => 'resolved']);
                    }
                }
            }
        });

        // Update sanctions to resolved based on Attendance status updates
        User::whereHas('attendances', function ($query) {
            $query->where('status', 'present');
        })->chunk(100, function ($students) {
            foreach ($students as $student) {
                $attendances = $student->attendances()->where('status', 'present')->get();

                foreach ($attendances as $attendance) {
                    $activityName = optional($attendance->activity)->name ?? 'Unknown Activity';
                    $semesterId = optional($attendance->activity)->semester_id;
                    $schoolYear = optional($attendance->activity)->school_year;

                    $sanctions = Sanction::where([
                        ['student_id', $student->id],
                        ['type', "Absence from $activityName"],
                        ['semester_id', $semesterId],
                        ['school_year', $schoolYear]
                    ])->where('resolved', 'not resolved')->get();

                    foreach ($sanctions as $sanction) {
                        $sanction->update(['resolved' => 'resolved']);
                    }
                }
            }
        });
    }





    public function resolveSanction($sanctionId)
    {
        $sanction = Sanction::find($sanctionId);
        if ($sanction) {
            $sanction->resolved = 'resolved'; // Use ENUM value
            $sanction->save();

            // Update the student's clearance status after resolving
            $student = User::find($sanction->student_id);
            if ($student) {
                $student->updateClearanceStatus();
            }

            Log::info("Sanction ID {$sanction->id} marked as resolved. Clearance status updated.");
        }
    }
}
