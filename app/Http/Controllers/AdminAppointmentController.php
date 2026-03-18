<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AdminAppointmentController extends Controller {
    public function pending() {
        $appointments = Appointment::where('status','pending_payment')->with('doctor','patient')->paginate(20);
        return view('admin.appointments_pending', compact('appointments'));
    }

    public function markPaid(Request $req, Appointment $appointment) {
        $appointment->update([
            'is_paid' => true,
            'status' => 'scheduled',
            'payment_reference' => $req->payment_reference ?? 'clinic-cash',
        ]);
        return back()->with('success','Marked as paid.');
    }
}
