@extends('front.amp.layout')

@section('script')
  <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
@endsection

@section('content')
@foreach($home as $row)
@if($row->name == 'Slider')
      <amp-carousel id="carousel-with-preview"
        width="450"
        height="300"
        layout="responsive"
        type="slides">

@foreach($Slider as $slide)
        <amp-img src="{{asset('galeri/580x370').'/'.$slide->gambar}}"
          width="580"
          height="370"
          layout="responsive"
          alt="$slide->judul"></amp-img>
@endforeach                  
      </amp-carousel>
@elseif($row->name == 'Profile')
      <section class="block-section">
        <div class="p-0-15">
          <h1 class="text-center">{{$row->judul}}</h1>
          <?= preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6',$main['profile_website']->deskripsi); ?>
          <amp-img src="{{asset('gambar/580x370').'/'.$main['profile_website']->gambar}}"
            width="580"
            height="370"
            layout="responsive"
            alt="{{$main['profile_website']->judul}}">
        </amp-img>
        </div>
      </section>
@elseif($row->name == 'Product')
    <section class="block-section">
      <div class="p-0-15">
        <h1 class="text-center">{{$row->judul}}</h1>
@foreach($Product as $produk)
        <div class="card">          
          <a href="{{url('amp/category').'/'.$produk->slug}}" title="{{$produk->judul}}">
            <amp-img alt="{{$produk->judul}}"
              src="{{asset('gambar/580x370').'/'.$produk->gambar}}"
              width="1.33"
              height="1"
              layout="responsive">
            </amp-img>
          </a>
          <a href="{{url('amp/category').'/'.$produk->slug}}" title="{{$produk->judul}}" class="link-title">
            <h3>{{$produk->judul}}</h3>
          </a>
@if(trim($produk->seo_deskripsi) != '')
          <div class="p-10">            
    <?= substr(strip_tags($produk->seo_deskripsi), 0,150) ?>
          </div>
@endif
        </div>
@endforeach
      </div>
    </section>
@elseif($row->name == 'Special')
    <section class="block-section">
      <div class="p-0-15">
        <h1 class="text-center">{{$row->judul}}</h1>
  @foreach($Special as $spesial)
        <div class="card">
          <a href="{{ $spesial['link'] }}" title="{{$spesial['title']}}">
              <amp-img alt="{{$spesial['title']}}"
                src="{{$spesial['img_path'].'580x370'.$spesial['img']}}"
                width="1.33"
                height="1"
                layout="responsive">
              </amp-img>
          </a>
          <a href="{{ $spesial['link'] }}" title="{{$spesial['title']}}" class="link-title">
            <h3>{{$spesial['title']}}</h3>
          </a>
          <div class="p-10">            
            {{$spesial['description']}}            
          </div>
        </div>
      </div>
    </section>
  @endforeach
@elseif($row->name == 'Transport')
    <section class="block-section">
      <div class="p-0-15">
        <h1 class="text-center">{{$row->judul}}</h1>
  @foreach($Transport as $key)
        <div class="card">          
              
          <amp-img alt="{{$key->judul}}"
            src="{{asset('gambar/580x370').'/'.$key->gambar}}"
            width="1.33"
            height="1"
            layout="responsive">
          </amp-img>
          
          <h3>{{$key->judul}}</h3>          
          <div class="p-10">
            <?= preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6',$key->deskripsi) ?>
          </div>
          @if($transport_button == true)          
            <div class="p-10 text-center">
              <a href="{{ url('amp/booking.html')}}" title="{{ $main['label']['Booking'] }}" class="btn">{{ $main['label']['Booking'] }}</a>
            </div>
          @endif
        </div>
      </div>
    </section>
  @endforeach

@else   
@endif
@endforeach

@endsection     