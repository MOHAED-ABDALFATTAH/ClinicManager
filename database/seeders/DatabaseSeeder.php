<?php

// namespace Database\Seeders;

// use App\Models\User;
// // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DoctorSchedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run()
{
    // create an example doctor
    $doctor = User::factory()->create([
        'name' => 'Dr. Ahmed',
        'email' => 'doctor@example.com',
        'password' => bcrypt('password'),
        'is_doctor' => true,
        'specialty' => 'General Medicine'
    ]);

    // create a sample patient
    $patient = User::factory()->create([
        'name' => 'Patient One',
        'email' => 'patient@example.com',
        'password' => bcrypt('password'),
        'is_doctor' => false
    ]);

    // schedule: Monday 09:00-12:00, Wednesday 14:00-17:00
    DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'weekday' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 20
    ]);
    DoctorSchedule::create([
        'doctor_id' => $doctor->id,
        'weekday' => 3, 'start_time' => '14:00:00', 'end_time' => '17:00:00', 'slot_minutes' => 30
    ]);
}
};

