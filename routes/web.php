<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrganigrammeController;
use App\Http\Controllers\RecoveryRequestController;
use App\Http\Controllers\EmployeeProgressController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('users', UserController::class); 
});



Route::resource('roles', RoleController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('contracts', ContractController::class);

Route::get('/employees/{employee}', [App\Http\Controllers\EmployeeController::class, 'show'])->name('employees.show');


Route::post('/employees/{employee}/career-steps', 
    [App\Http\Controllers\CareerStepController::class, 'store'])
    ->name('employees.add-career-step');

Route::put('/career-steps/{careerStep}', 
    [App\Http\Controllers\CareerStepController::class, 'update'])
    ->name('career-steps.update');

Route::delete('/career-steps/{careerStep}', 
    [App\Http\Controllers\CareerStepController::class, 'destroy'])
    ->name('career-steps.destroy');



    // Route::middleware('auth')->group(function () {
    //     Route::get('/leave/requests', [LeaveRequestController::class, 'index'])->name('leave.requests');
    //     Route::get('/leave/requests/create', [LeaveRequestController::class, 'create'])->name('leave.requests.create');
    //     Route::post('/leave/requests', [LeaveRequestController::class, 'store'])->name('leave.requests.store');  
    // });

    
// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [EmployeeController::class, 'index']);  
//     Route::get('/leave/requests', [LeaveRequestController::class, 'index']);  
//     Route::post('/leave/requests', [LeaveRequestController::class, 'store']);  

//     Route::get('/hr/leave/requests', [LeaveRequestController::class, 'hrIndex']);  
//     Route::post('/hr/leave/{id}/approve', [LeaveRequestController::class, 'approve']);  
//     Route::post('/hr/leave/{id}/reject', [LeaveRequestController::class, 'reject']);  
// });







Route::middleware('auth')->group(function () {
    // Employee Routes
    Route::get('/dashboard', [EmployeeController::class, 'index'])->name('dashboard');
    
    Route::get('/leave/requests', [LeaveRequestController::class, 'index'])->name('leave.requests.index');
    Route::get('/leave/requests/create', [LeaveRequestController::class, 'create'])->name('leave.requests.create');
    Route::post('/leave/requests', [LeaveRequestController::class, 'store'])->name('leave.requests.store');
    
    Route::delete('/leave-requests/{id}', [LeaveRequestController::class, 'destroy'])->name('leave.requests.destroy');


    // HR Routes - See all requests (leave & recovery)
    Route::get('/hr/leave/requests', [LeaveRequestController::class, 'hrIndex'])->name('hr.leave.requests');
    Route::post('/hr/leave/{id}/approve', [LeaveRequestController::class, 'approve'])->name('hr.leave.approve');
    Route::post('/hr/leave/{id}/reject', [LeaveRequestController::class, 'reject'])->name('hr.leave.reject');

    Route::get('/hr/recovery/requests', [RecoveryRequestController::class, 'hrIndex'])->name('hr.recovery.requests');
    Route::post('/hr/recovery/{id}/approve', [RecoveryRequestController::class, 'approve'])->name('hr.recovery.approve');
    Route::post('/hr/recovery/{id}/reject', [RecoveryRequestController::class, 'reject'])->name('hr.recovery.reject');

    // Manager Routes - Only see requests from their team
    Route::get('/manager/leave/requests', [LeaveRequestController::class, 'managerIndex'])->name('manager.leave.requests');
    Route::post('/manager/leave/{id}/approve', [LeaveRequestController::class, 'managerApprove'])->name('manager.leave.approve');
    Route::post('/manager/leave/{id}/reject', [LeaveRequestController::class, 'managerReject'])->name('manager.leave.reject');

    Route::get('/manager/recovery/requests', [RecoveryRequestController::class, 'managerIndex'])->name('manager.recovery.requests');
    Route::post('/manager/recovery/{id}/approve', [RecoveryRequestController::class, 'managerApprove'])->name('manager.recovery.approve');
    Route::post('/manager/recovery/{id}/reject', [RecoveryRequestController::class, 'managerReject'])->name('manager.recovery.reject');
});


Route::get('/formations', [FormationController::class, 'index'])->name('formations.index');
Route::post('/formations/enroll', [FormationController::class, 'enrollEmployee'])->name('formations.enroll');
Route::post('/formations/complete', [FormationController::class, 'completeFormation'])->name('formations.complete');

    
Route::get('/organigramme', [OrganigrammeController::class, 'index'])
    ->middleware(['auth'])
    ->name('organigramme');



Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/mark-notification/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

// Leave request notifications
Route::post('/notify-leave-request/{employee_id}', [NotificationController::class, 'notifyLeaveRequest']);
Route::post('/notify-leave-response/{employee_id}/{status}', [NotificationController::class, 'notifyLeaveResponse']);

// Formation notifications
Route::post('/notify-formation-enrollment/{employee_id}', [NotificationController::class, 'notifyFormationEnrollment']);
Route::post('/notify-formation-result/{employee_id}/{status}', [NotificationController::class, 'notifyFormationResult']);




require __DIR__.'/auth.php';
