
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
  <h1 class="text-2xl font-semibold mb-4">Doctors</h1>
  @if($doctors->isEmpty())
    <p>No doctors found.</p>
  @else
    <div class="grid grid-cols-3 gap-4">
      @foreach($doctors as $doc)
        <div class="p-4 border rounded">
          <h2 class="font-bold">{{ $doc->name }}</h2>
          <p class="text-sm text-gray-600">{{ $doc->specialty ?? 'General' }}</p>
          <a href="{{ route('doctors.show',$doc) }}" class="inline-block mt-2 px-3 py-1 bg-blue-600 text-white rounded">Book</a>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection