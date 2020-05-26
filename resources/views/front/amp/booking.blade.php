@extends('front.amp.layout')
@section('content')
<section class="block-section">
    <div class="p-0-15 text-center">
      <h1 class="text-center">{{ $main['label']['Booking'] }} </h1>
      <a href="{{ url('booking.html') }}" title="booking" class="btn">Click To Booking </a>
    </div>
</section>

@endsection     