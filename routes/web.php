<?php
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\Officer\ReportsController;
use App\Http\Controllers\Officer\ActivityController;
use App\Http\Controllers\Officer\AttendanceController;
use App\Http\Controllers\Officer\ClearanceController;
use App\Http\Controllers\Officer\SanctionController;
use App\Http\Controllers\Officer\StudentsController;
use App\Http\Controllers\Officer\FinanceController;
use App\Http\Controllers\Officer\FeesController;
use App\Http\Controllers\Officer\AuditController;
use App\Http\Controllers\Officer\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentFinanceController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Middleware\CheckFinanceRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [StudentDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('finance', StudentFinanceController::class);
    Route::resource('sAttendance', StudentAttendanceController::class);
    Route::get('/finance/receipt/{id}', [StudentFinanceController::class, 'receipt'])->name('receipt');
    Route::get('/check-status', [UserController::class, 'checkStatus'])->name('check.status');



});



Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::resource('astudents', StudentController::class);
    Route::resource('officers', OfficerController::class);
    Route::resource('admins', AdminController::class);



    Route::get('pending-users', [AdminAuthController::class, 'index'])->name('admin.pending_users');

    // Separate approval routes for users and officers
    Route::post('approve-user/{id}', [AdminAuthController::class, 'approveUser'])->name('admin.approveUser');
    Route::post('approve-officer/{id}', [AdminAuthController::class, 'approveOfficer'])->name('admin.approveOfficer');

    // Separate rejection routes for users and officers (if needed)
    Route::post('reject-user/{id}', [AdminAuthController::class, 'rejectUser'])->name('admin.rejectUser');
    Route::post('reject-officer/{id}', [AdminAuthController::class, 'rejectOfficer'])->name('admin.rejectOfficer');

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});


Route::prefix('officer')->middleware('auth:officer')->group(function () {
    // Resources
    Route::resource('students', StudentsController::class);
    Route::resource('finances', FinanceController::class);
    Route::resource('fees', FeesController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('sanctions', SanctionController::class);
    Route::resource('clearances', ClearanceController::class);
    Route::resource('audit', AuditController::class);
    Route::resource('finances', FinanceController::class);
    Route::post('attendance/mark', [AttendanceController::class, 'markAttendanceByBarcode'])->name('attendance.mark');

    Route::post('attendance/mark', [AttendanceController::class, 'markAttendanceByBarcode'])->name('attendance.mark');

    // Custom routes

    // Reports
    Route::get('reports/attendance', [ReportsController::class, 'attendanceReport'])->name('reports.attendance');
    Route::get('reports/attendance_statistics', [ReportsController::class, 'attendanceStats'])->name('reports.attendance_statistics');
    Route::get('reports/finance', [ReportsController::class, 'financeReport'])->name('reports.finance');
    Route::get('reports/sanction_statistics', [ReportsController::class, 'sanctionStats'])->name('reports.sanction_statistics');
    Route::get('reports/sanction', [ReportsController::class, 'sanctionReport'])->name('reports.sanction');
    Route::get('reports/clearance', [ReportsController::class, 'clearanceReport'])->name('reports.clearance');
    Route::get('reports/clearance_statistics', [ReportsController::class, 'clearanceStats'])->name('reports.clearance_statistics');
    Route::get('reports/student', [ReportsController::class, 'studentReport'])->name('reports.student');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('officer.dashboard');
});




Route::get('/officer/dashboard', [DashboardController::class, 'index'])->name('officer.dashboard');
Route::post('/finances/update-payment-status', [FinanceController::class, 'updatePaymentStatus'])->name('finances.updatePaymentStatus')->middleware('auth:officer');
require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
require __DIR__.'/officer-auth.php';
