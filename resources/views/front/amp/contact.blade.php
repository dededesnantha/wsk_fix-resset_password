@extends('front.amp.layout')

@section('content')
<section class="block-section">
    <div class="p-0-15 text-center m-t-20">
      <h1 class="text-center"> {{$main['label']['Contact']}} </h1>
      @if(trim($main['profile_website']->logo) != '')
        <amp-img alt="Logo"
            src="{{url('gambar').'/'.$main['profile_website']->logo}}"
            width="100px"
            height="100px">
        </amp-img>
      @endif
      
     <p>{{ $main['label']['Address'] }} : {{$main['profile_website']->alamat}}</p>        

    @foreach($main['contact'] as $cont)
      <p> 
        
      @if(!$cont['image_null'])
          <a href="{{ $cont['link'] }}" title="{{ $cont['title'] }}" target="_blank" class="no-decoration">
            <amp-img alt="{{ $cont['title'] }}"
              src="{{ $cont['img'] }}"
              width="30px"
              height="30px">
            </amp-img>
          </a>
        @endif
        {{$cont['title']}} : <a href="{{ $cont['link'] }}" title="{{ $cont['title'] }}" target="_blank">{{$cont['id']}}</a></p>

    @endforeach
              
    @foreach($main['social_media'] as $social_media)
      <a href="{{$social_media->link}}" title="{{$social_media->judul}}" class="no-decoration">            
        <amp-img alt="{{$social_media->judul}}"
          src="{{asset('gambar').'/'.$social_media->gambar}}"
          width="40px"
          height="40px">
        </amp-img>
      </a>
    @endforeach

  
    </div>
    <div class="text-center m-b-30">        
      <a href="{{ str_replace(url('amp'), url(''), Request::fullUrl()) }}" title="Normal Page" class="btn">Normal Page </a>
    </div>
</section>

@endsection     