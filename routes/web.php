<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminAppointmentController;

Route::middleware('auth')->group(function () {
    Route::get('/patient/dashboard', [PatientDashboardController::class,'index'])->name('patient.dashboard');

    Route::get('/doctors', [BookingController::class,'doctors'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [BookingController::class,'showDoctor'])->name('doctors.show');
    Route::get('/doctors/{doctor}/slots', [BookingController::class,'availableSlots'])->name('doctors.slots');
    Route::post('/doctors/{doctor}/book', [BookingController::class,'store'])->name('doctors.book');

    // admin clinic staff
    Route::get('/admin/appointments/pending', [AdminAppointmentController::class,'pending'])->name('admin.appointments.pending');
    Route::post('/admin/appointments/{appointment}/mark-paid', [AdminAppointmentController::class,'markPaid'])->name('admin.appointments.markPaid');
});

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

require __DIR__.'/auth.php';
