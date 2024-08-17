<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\User;
use App\Models\Fees;
use Illuminate\Http\Request;
class StudentFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Auth::user();
        $finances = Finance::where('user_id', $student->id)->with('fee')->get();

        return view('finance.index', compact('finances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function receipt($id)
{
    $finance = Finance::findOrFail($id);

    if ($finance->status != 'Paid') {
        return redirect()->route('student.finance.index')->with('error', 'Receipt is not available for unpaid fees.');
    }

    return view('finance.receipt', compact('finance'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Auth::user();
        $finance = Finance::where('id', $id)
                          ->where('user_id', $student->id)
                          ->firstOrFail();

        return view('finance.show', compact('finance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
