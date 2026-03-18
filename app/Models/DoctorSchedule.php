<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model {
    protected $fillable = ['doctor_id','weekday','start_time','end_time','slot_minutes'];

    public function doctor() {
        return $this->belongsTo(User::class,'doctor_id');
    }
}
