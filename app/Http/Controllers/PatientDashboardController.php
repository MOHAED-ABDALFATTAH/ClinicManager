<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Appointment;

class PatientDashboardController extends Controller {
    public function index(Request $request) {
        $user = $request->user();
        $appointments = Appointment::with('doctor')
            ->where('patient_id', $user->id)
            ->orderByDesc('date')
            ->paginate(10);
        return view('patient.dashboard', compact('appointments'));
    }
}
