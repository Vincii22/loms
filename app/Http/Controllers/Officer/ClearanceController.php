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
        $searchName = $request->input('search_name');
        $searchSchoolId = $request->input('search_school_id');
        $status = $request->input('status');

        $clearances = User::with(['clearance'])
            ->when($searchName, function ($query, $searchName) {
                return $query->where('name', 'like', "%{$searchName}%");
            })
            ->when($searchSchoolId, function ($query, $searchSchoolId) {
                return $query->where('school_id', 'like', "%{$searchSchoolId}%");
            })
            ->when($status, function ($query, $status) {
                return $query->whereHas('clearance', function ($query) use ($status) {
                    $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
                });
            })
            ->paginate(10);

        return view('officer.clearance.index', [
            'clearances' => $clearances,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:not cleared,cleared',
        ]);

        $user = User::findOrFail($id);
        $clearance = $user->clearance;

        if ($clearance) {
            $clearance->update(['status' => $request->status]);
        } else {
            Clearance::create([
                'user_id' => $id,
                'status' => $request->status,
            ]);
        }

        return redirect()->route('clearances.index')->with('success', 'Clearance status updated successfully!');
    }
}
