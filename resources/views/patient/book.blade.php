@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
  <h1 class="text-2xl font-semibold mb-4">Book with Dr. {{ $doctor->name }}</h1>

  <div class="mb-4">
    <label class="block mb-1">Choose date</label>
    <input id="date" type="date" class="border p-2 rounded w-full" />
  </div>

  <div id="slots" class="mb-4">Pick a date to see available slots</div>

  <form method="POST" action="{{ route('doctors.book', $doctor) }}">
    @csrf
    <input type="hidden" name="date" id="form_date" />
    <input type="hidden" name="time" id="form_time" />
    <textarea name="notes" placeholder="Notes (optional)" class="w-full border p-2 rounded" rows="3"></textarea>
    <div class="mt-3">
      <button id="bookBtn" disabled class="px-4 py-2 bg-gray-400 text-white rounded">Book (Pay at clinic)</button>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const dateInput = document.getElementById('date');
  const slotsDiv = document.getElementById('slots');
  const formDate = document.getElementById('form_date');
  const formTime = document.getElementById('form_time');
  const bookBtn = document.getElementById('bookBtn');

  dateInput.addEventListener('change', async () => {
    const date = dateInput.value;
    formTime.value = '';
    bookBtn.disabled = true;
    formDate.value = date;
    if (!date) { slotsDiv.innerHTML = 'Pick a date'; return; }

    slotsDiv.innerHTML = 'Loading...';
    const res = await fetch(`{{ url('/doctors/'.$doctor->id.'/slots') }}?date=${date}`, { headers: { 'Accept': 'application/json' }});
    const data = await res.json();
    if (!data.slots || data.slots.length === 0) {
      slotsDiv.innerHTML = '<div class="text-gray-600">No available slots on this date.</div>';
      return;
    }

    const grid = document.createElement('div');
    grid.className = 'grid grid-cols-4 gap-2';
    data.slots.forEach(s => {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'p-2 border rounded';
      b.textContent = s.time;
      b.addEventListener('click', () => {
        document.querySelectorAll('#slots button').forEach(x=>x.classList.remove('bg-blue-200'));
        b.classList.add('bg-blue-200');
        formTime.value = s.time;
        bookBtn.disabled = false;
      });
      grid.appendChild(b);
    });
    slotsDiv.innerHTML = '';
    slotsDiv.appendChild(grid);
  });
});
</script>
@endsection
