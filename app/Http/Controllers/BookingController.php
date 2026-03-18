<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DoctorSchedule;
use App\Models\Appointment;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function doctors() {
        $doctors = User::where('is_doctor', true)->get();
        return view('patient.doctors', compact('doctors'));
    }

    public function showDoctor(User $doctor) {
        if (! $doctor->is_doctor) abort(404);
        return view('patient.book', compact('doctor'));
    }

    // AJAX: GET /doctors/{doctor}/slots?date=YYYY-MM-DD
    public function availableSlots(Request $req, User $doctor) {
        $req->validate(['date' => 'required|date']);
        if (! $doctor->is_doctor) return response()->json(['slots'=>[]]);

        $date = Carbon::parse($req->date);
        $weekday = (int)$date->dayOfWeek; // 0..6
        $schedules = DoctorSchedule::where('doctor_id',$doctor->id)->where('weekday',$weekday)->get();
        $slots = [];

        foreach ($schedules as $s) {
            $start = Carbon::parse($s->start_time);
            $end = Carbon::parse($s->end_time);
            $slotMinutes = (int)$s->slot_minutes;

            $current = $start->copy();
            while ($current->lessThan($end)) {
                $slotStart = $current->format('H:i:s');
                $slotDateTime = Carbon::parse($date->toDateString().' '.$slotStart);

                if ($slotDateTime->lessThan(now())) { $current->addMinutes($slotMinutes); continue; }

                $exists = Appointment::where('doctor_id',$doctor->id)
                    ->where('date',$date->toDateString())
                    ->where('time',$slotStart)
                    ->exists();

                if (! $exists) {
                    $slots[] = ['time' => substr($slotStart,0,5), 'datetime' => $slotDateTime->toDateTimeString()];
                }
                $current->addMinutes($slotMinutes);
            }
        }

        return response()->json(['slots'=>$slots]);
    }

    // POST /doctors/{doctor}/book
    public function store(Request $req, User $doctor) {
        $req->validate(['date'=>'required|date','time'=>'required|string']);
        if (! $doctor->is_doctor) return back()->with('error','Invalid doctor');

        $date = Carbon::parse($req->date)->toDateString();
        $time = Carbon::createFromFormat('H:i', $req->time)->format('H:i:s');

        $exists = Appointment::where('doctor_id',$doctor->id)->where('date',$date)->where('time',$time)->exists();
        if ($exists) return back()->with('error','Slot already booked.');

        Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $req->user()->id,
            'date' => $date,
            'time' => $time,
            'duration' => 30,
            'status' => 'pending_payment',
            'is_paid' => false,
            'notes' => $req->notes ?? null,
        ]);

        return redirect()->route('patient.dashboard')->with('success','Appointment created as pending. Pay at the clinic to confirm.');
    }
}
