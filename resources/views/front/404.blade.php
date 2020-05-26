@extends('front.layout')

@section('content')
<div class="w3-row" style="max-width:1200px;margin-top: 46px;margin:0 auto">
  <div class="w3-container w3-center w3-padding" style="margin-top: 50px"></div>
  <div class="w3-col l8 s12">
    <div class="w3-container w3-white ">      
      <div class="w3-left-align">
        <h1>Error 404</h1>
        <h2>{{ $main['label']['Page Not Found!!'] }}</h2>
        <form method="get" action="{{url('search')}}">
          <input type="text"  name="search" placeholder="{{ $main['label']['Search'] }}" style="width: 100%;border: 3px solid #e0e0e0;padding: 10px;">
        </form>
      </div>
    </div>
    <hr>
  </div> 
  @include('front.inc.sidebar')  
</div>
@endsection