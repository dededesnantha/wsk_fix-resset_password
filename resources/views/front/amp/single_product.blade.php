@extends('front.amp.layout')

@section('content')
<section class="block-section">
    <div class="p-0-5 ">
      <h1 class="text-center">
        {{@$single->judul}}
      </h1>
      <div class="card">    
        <amp-img alt="{{@$single->judul}}"
          src="{{asset('gambar/568x427').'/'.@$single->gambar}}"
          width="1.33"
          height="1"
          layout="responsive">
        </amp-img>
        @include('front.amp.component.share')    
          
        <div class="p-0-10">
          @if(round($single->price) != 0)
            <div class="text-right">
              $main['label']['Price Symbol']. {{$single->price}}
            </div>
          @endif
          <?php $string = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6',@$single->deskripsi); $pattern = '/<img/i';$replacement = '<amp-img';?>
          <?= preg_replace($pattern, $replacement, $string) ?>
          @include('front.amp.component.list_page')
          @include('front.amp.component.widget')
        </div>
        <br>
        <div class="text-center">        
          <a href="{{ str_replace(url('amp'), url(''), Request::fullUrl()) }}" title="Booking" class="btn">{{ $main['label']['Booking'] }}</a>
        </div>
        @include('front.amp.component.tag')

        <div class="m-b-30 text-center">
          <a href="{{ str_replace(url('amp'), url(''), Request::fullUrl()) }}" title="Normal Page" class="btn">Normal Page </a>
        </div>
      </div>
      @include('front.amp.component.related_product')  
  </div>

</section>

@endsection     