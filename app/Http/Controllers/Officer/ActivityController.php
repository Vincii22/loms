<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Semester;
use App\Models\User;
use App\Models\Sanction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Activity::query();

        if ($request->has('semester_id') && $request->input('semester_id') != '') {
            $query->where('semester_id', $request->input('semester_id'));
        }

        if ($request->has('school_year') && $request->input('school_year') != '') {
            $query->where('school_year', $request->input('school_year'));
        }

        $activities = $query->get();
        $semesters = Semester::all(); // Fetch all semesters for filter dropdown

        return view('officer.activities.index', compact('activities', 'semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $semesters = Semester::all();
        return view('officer.activities.create', compact('semesters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'semester_id' => 'nullable|exists:semesters,id',
            'school_year' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $data['image'] = basename($imagePath);
        }

        // Create the new activity
        $activity = Activity::create($data);

        // Fetch all students
        $students = User::all();

        // Create attendance records with "Absent" status
        foreach ($students as $student) {
            $activity->attendances()->create([
                'student_id' => $student->id,
                'status' => 'Absent',
            ]);
        }

        return redirect()->route('activities.index')->with('success', 'Activity created successfully with default attendance records.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = Activity::findOrFail($id);
        $semesters = Semester::all();
        return view('officer.activities.edit', compact('activity', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'semester_id' => 'nullable|exists:semesters,id',
            'school_year' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($activity->image) {
                Storage::delete('public/images/' . $activity->image);
            }

            $imagePath = $request->file('image')->store('public/images');
            $data['image'] = basename($imagePath);
        }

        $activity->update($data);
        return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
         // Find all sanctions related to this activity
    $sanctions = Sanction::where('type', 'LIKE', "Absence from %")
    ->whereHas('student.attendances.activity', function ($query) use ($activity) {
        $query->where('id', $activity->id);
    })->get();

    // Delete the sanctions
    foreach ($sanctions as $sanction) {
    $sanction->delete();
    }


        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    }
    }

