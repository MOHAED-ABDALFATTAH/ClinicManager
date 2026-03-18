@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
  <h1 class="text-2xl font-semibold mb-4">Pending Appointments</h1>
  @if(session('success')) <div class="p-2 bg-green-100 mb-3">{{ session('success') }}</div> @endif
  <table class="w-full">
    <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Action</th></tr></thead>
    <tbody>
      @foreach($appointments as $a)
      <tr class="border-t">
        <td>{{ $a->patient->name }}</td>
        <td>{{ $a->doctor->name }}</td>
        <td>{{ $a->date }}</td>
        <td>{{ \Carbon\Carbon::parse($a->time)->format('H:i') }}</td>
        <td>
          <form method="POST" action="{{ route('admin.appointments.markPaid', $a) }}">
            @csrf
            <input name="payment_reference" placeholder="ref (optional)" class="border p-1" />
            <button class="px-3 py-1 bg-green-600 text-white rounded">Mark Paid</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $appointments->links() }}</div>
</div>
@endsection
