<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {
    protected $fillable = [
      'doctor_id','patient_id','date','time','duration','status','is_paid','notes','payment_reference'
    ];

    protected $casts = ['is_paid' => 'boolean', 'date' => 'date'];

    public function doctor() {
      return $this->belongsTo(User::class,'doctor_id');
    }
    public function patient() {
      return $this->belongsTo(User::class,'patient_id');
    }
}
