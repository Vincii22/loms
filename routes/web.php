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

});



Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::resource('astudents', StudentController::class);
    Route::resource('officers', OfficerController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('adminDashboard', AdminDashboardController::class);


    Route::get('pending-users', [AdminAuthController::class, 'index'])->name('admin.pending_users');
    Route::post('approve/{id}', [AdminAuthController::class, 'approve'])->name('admin.approve');
    Route::post('reject/{id}', [AdminAuthController::class, 'reject'])->name('admin.reject');
});


Route::prefix('officer')->middleware('auth:officer')->group(function () {
    Route::resource('students', StudentsController::class);
    Route::resource('finances', FinanceController::class);
    Route::post('/finances/update-payment-status', [FinanceController::class, 'updatePaymentStatus'])->name('finances.updatePaymentStatus');
    Route::resource('fees', FeesController::class);
    Route::resource('attendance', AttendanceController::class);
    route::post('/attendance/mark-by-barcode', [AttendanceController::class, 'markAttendanceByBarcode'])->name('attendance.mark');
    Route::resource('activities', ActivityController::class);
    Route::resource('sanctions', SanctionController::class);

    Route::resource('clearances', ClearanceController::class);
    Route::resource('audit', AuditController::class);
});

Route::prefix('officer')->middleware('auth:officer')->group(function () {

    Route::get('reports/attendance', [ReportsController::class, 'attendanceReport'])->name('reports.attendance');
    Route::get('reports/attendance_statistics', [ReportsController::class, 'attendanceStats'])->name('reports.attendance_statistics');
    Route::get('reports/finance', [ReportsController::class, 'financeReport'])->name('reports.finance');
    Route::get('reports/sanction', [ReportsController::class, 'sanctionReport'])->name('reports.sanction');
    Route::get('reports/clearance', [ReportsController::class, 'clearanceReport'])->name('reports.clearance');
    Route::get('reports/student', [ReportsController::class, 'studentReport'])->name('reports.student');
});



route::middleware('auth')->get('/check-status', [UserController::class, 'checkStatus'])->name('check.status');

Route::get('/officer/dashboard', [DashboardController::class, 'index'])->name('officer.dashboard');
Route::post('/finances/update-payment-status', [FinanceController::class, 'updatePaymentStatus'])->name('finances.updatePaymentStatus')->middleware('auth:officer');
require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
require __DIR__.'/officer-auth.php';
