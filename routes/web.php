<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeProgressController;

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



require __DIR__.'/auth.php';
