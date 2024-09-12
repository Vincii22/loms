<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    public function checkStatus()
    {
        try {
            $user = Auth::user();
            if ($user) {
                return response()->json(['status' => $user->status]);
            }
            return response()->json(['status' => 'pending']);
        } catch (\Exception $e) {
            Log::error('Error in checkStatus method: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }


}
?>
