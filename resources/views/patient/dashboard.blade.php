@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
  <h1 class="text-2xl font-semibold mb-4">My Appointments</h1>
  <a href="{{ route('doctors.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Book new appointment</a>

  @if(session('success')) <div class="mt-3 p-3 bg-green-100 rounded">{{ session('success') }}</div> @endif
  @if(session('error')) <div class="mt-3 p-3 bg-red-100 rounded">{{ session('error') }}</div> @endif

  <table class="w-full mt-6 border-collapse">
    <thead><tr class="text-left"><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
    <tbody>
      @foreach($appointments as $a)
      <tr class="border-t">
        <td class="py-3">{{ $a->doctor->name }} <div class="text-sm text-gray-600">{{ $a->doctor->specialty }}</div></td>
        <td>{{ $a->date->format('Y-m-d') }}</td>
        <td>{{ \Carbon\Carbon::parse($a->time)->format('H:i') }}</td>
        <td>
          @if(!$a->is_paid) <span class="text-yellow-700">Pending payment</span>
          @else <span class="text-green-700">Confirmed</span> @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-4">{{ $appointments->links() }}</div>
</div>
@endsection
