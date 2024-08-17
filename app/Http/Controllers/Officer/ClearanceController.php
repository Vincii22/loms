<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clearance;


class ClearanceController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status'); // Get the status filter from the request

        // Fetch users with their clearance records
        $query = User::with('clearance');

        if ($statusFilter) {
            // Filter by status if provided
            $query->whereHas('clearance', function($q) use ($statusFilter) {
                $q->where('status', $statusFilter);
            });
        }

        $clearances = $query->paginate(10); // Adjust the number of items per page as needed

        return view('officer.clearance.index', [
            'clearances' => $clearances,
            'statusFilter' => $statusFilter // Pass the status filter to the view
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:eligible,not eligible,cleared'
        ]);

        $clearance = Clearance::where('user_id', $id)->first();
        if ($clearance) {
            $clearance->update(['status' => $request->status]);
        } else {
            // Create a new clearance record if none exists
            Clearance::create([
                'user_id' => $id,
                'status' => $request->status
            ]);
        }

        return redirect()->route('clearances.index')->with('success', 'Clearance status updated.');
    }
}
