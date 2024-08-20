<?php

namespace App\Http\Controllers\Officer;
use App\Models\Sanction;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Finance;
use App\Models\Organization;
use App\Models\Course;
use App\Models\Year;
use Barryvdh\Debugbar\Facade as Debugbar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SanctionController extends Controller
{
    public function index(Request $request)
    {
        $searchName = $request->input('search_name');
        $searchSchoolId = $request->input('search_school_id');
        $filterOrganization = $request->input('filter_organization');
        $filterCourse = $request->input('filter_course');
        $filterYear = $request->input('filter_year');
        $filterType = $request->input('filter_type'); // New filter

        // Log request inputs
        Debugbar::info($request->all());

        $sanctions = Sanction::with('student.organization', 'student.course', 'student.year')
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
            ->when($filterOrganization, function ($query, $filterOrganization) {
                return $query->whereHas('student.organization', function ($query) use ($filterOrganization) {
                    $query->where('id', $filterOrganization);
                });
            })
            ->when($filterCourse, function ($query, $filterCourse) {
                return $query->whereHas('student.course', function ($query) use ($filterCourse) {
                    $query->where('id', $filterCourse);
                });
            })
            ->when($filterYear, function ($query, $filterYear) {
                return $query->whereHas('student.year', function ($query) use ($filterYear) {
                    $query->where('id', $filterYear);
                });
            })
            ->when($filterType, function ($query, $filterType) {
                return $query->where('type', $filterType);
            })
            ->paginate();

        // Log the query and results
        Debugbar::info($sanctions);

        // Fetch all organizations, courses, and years for filtering options
        $organizations = Organization::all();
        $courses = Course::all();
        $years = Year::all();

        // Log fetched data
        Debugbar::info($organizations);
        Debugbar::info($courses);
        Debugbar::info($years);

        $this->checkSanctions();
        return view('officer.sanctions.index', compact('sanctions', 'organizations', 'courses', 'years'));
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

        // Update user's clearance status based on sanctions
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
        $studentsWithUnpaidFees = User::whereHas('finances', function ($query) {
            $query->where('status', 'Not Paid');
        })->get();

        foreach ($studentsWithUnpaidFees as $student) {
            $unpaidFees = $student->finances->where('status', 'Not Paid');

            foreach ($unpaidFees as $fee) {
                $feeName = optional($fee->fee)->name ?? 'Unknown Fee';

                Sanction::firstOrCreate([
                    'student_id' => $student->id,
                    'type' => "Unpaid Fees - $feeName",
                    'description' => "Unpaid $feeName for the current term",
                    'fine_amount' => 100,
                    'resolved' => false,
                ]);

                // Ensure the clearance record exists
                if ($student->clearance) {
                    $student->clearance->status = 'not eligible';
                    $student->clearance->save();
                } else {
                    $student->clearance()->create(['status' => 'not eligible']);
                }
            }
        }

        // Check for absences and create sanctions
        $studentsAbsent = User::whereHas('attendances', function ($query) {
            $query->where('status', 'absent');
        })->get();

        foreach ($studentsAbsent as $student) {
            $attendance = $student->attendances()->latest()->first();

            if ($attendance) {
                $activityName = optional($attendance->activity)->name ?? 'Unknown Activity';

                $existingSanction = Sanction::where([
                    ['student_id', $student->id],
                    ['type', "Absence from $activityName"]
                ])->first();

                if (!$existingSanction) {
                    Sanction::create([
                        'student_id' => $student->id,
                        'type' => "Absence from $activityName",
                        'description' => 'Absent from mandatory activity',
                        'fine_amount' => 50,
                        'resolved' => false,
                    ]);

                    // Ensure the clearance record exists
                    if ($student->clearance) {
                        $student->clearance->status = 'not eligible';
                        $student->clearance->save();
                    } else {
                        $student->clearance()->create(['status' => 'not eligible']);
                    }
                }
            }
        }
    }

}
