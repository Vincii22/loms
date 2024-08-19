<?php

namespace App\Http\Controllers;

use App\Models\Sanction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facade as Debugbar;

class StudentSanctionController extends Controller
{

    public function index()
    {
      // Get the currently authenticated user (student)
      $student = Auth::user();

      Debugbar::info($student);

      // Retrieve all sanctions associated with the authenticated student
      $sanctions = Sanction::where('student_id', $student->id)->with('student')->get();

      Debugbar::info($sanctions);
      // Return the view with the sanctions data
      return view('sanction.index', compact('sanctions'));
    }

    public function show(string $id)
    {
        // Retrieve the specific sanction by its ID
        $sanction = Sanction::with('student')->findOrFail($id);

        Debugbar::info($sanction);
        // Check if the logged-in user is the owner of the sanction
        if ($sanction->student_id !== Auth::id()) {
            // If not, you can redirect or throw an error (for security purposes)
            return redirect()->route('sanctions.index')->with('error', 'Unauthorized access to sanction details.');
        }

        // Pass the sanction to the view
        return view('sanction.show', compact('sanction'));
    }



}
