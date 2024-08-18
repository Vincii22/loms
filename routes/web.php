<?php
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\Officer\ActivityController;
use App\Http\Controllers\Officer\AttendanceController;
use App\Http\Controllers\Officer\ClearanceController;
use App\Http\Controllers\Officer\SanctionController;
use App\Http\Controllers\Officer\StudentsController;
use App\Http\Controllers\Officer\FinanceController;
use App\Http\Controllers\Officer\FeesController;
use App\Http\Controllers\Officer\AuditController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentFinanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('finance', StudentFinanceController::class);
    Route::resource('sAttendance', StudentAttendanceController::class);
    Route::get('/finance/receipt/{id}', [StudentFinanceController::class, 'receipt'])->name('receipt');

});



Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('officers', OfficerController::class);
});

Route::prefix('officer')->middleware('auth:officer')->group(function () {
    Route::resource('students', StudentsController::class);
    Route::resource('finances', FinanceController::class);
    Route::resource('fees', FeesController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('sanctions', SanctionController::class);
    Route::resource('clearances', ClearanceController::class);
    Route::resource('audit', AuditController::class);

});

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
require __DIR__.'/officer-auth.php';
