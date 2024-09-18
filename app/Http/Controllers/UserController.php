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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->status === 'active') {
                // User is authenticated and active
                return response()->json(['status' => 'active']);
            } else {
                // User is authenticated but not active
                return response()->json(['status' => 'inactive']);
            }
        } else {
            // User is not authenticated
            return response()->json(['status' => 'unauthenticated'], 401);
        }
    }
}
?>
