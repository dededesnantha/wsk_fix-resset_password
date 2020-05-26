@extends('front.header_login')
@section('script')
<script src='https://www.google.com/recaptcha/api.js'></script>  
<script src="{{asset('front')}}/jquery-3.1.1.min.js" type="text/javascript"></script>
@endsection
@section('content')
<div class="container">
 <div class="c-12">
  @include('front.component.alert')
<form action="{{ url('form/mahasiswa/update/'.$data->id) }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
    <div class="row">
      <div class="col-25">
        <label>Nama Lengkap</label>
      </div>
      <div class="col-75">
        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required value="{{$data->nama_lengkap}}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Jenis Kelamin</label>
      </div>
      <div class="col-75">
      	@if($data->jk == 'pria')
	      	<span>
	      		<input type="radio" name="jk" value="pria" checked class="w3-check" required> pria
	      	</span>
	      	<span class="w3-padding">
	      		<input type="radio" name="jk" value="wanita" class="w3-check" required> wanita
	      	</span>
	      	@else
          	<span>
	      		<input type="radio" name="jk" value="pria" class="w3-check" required> pria
	      	</span>
	      	<span class="w3-padding">
	      		<input type="radio" name="jk" value="wanita" checked class="w3-check" required> wanita
	      	</span>
      	@endif
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Tempat Lahir</label>
      </div>
      <div class="col-75">
        <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" required value="{{$data->tempat_lahir}}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Tanggal Lahir</label>
      </div>
      <div class="col-75">
        <p><input class="w3-input w3-padding-16 w3-border" type="date" placeholder="Date" required="" name="tanggal_lahir"value="{{$data->tanggal_lahir}}"></p>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Asal Sekolah</label>
      </div>
      <div class="col-75">
        <input type="text" name="asal_sekolah" placeholder="Asal Sekolah" required value="{{$data->asal_sekolah}}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Jenis Kelamin</label>
      </div>
      <div class="col-75">
      	@if($data->jurusan == 'perhotelan')
	      	<span>
	          <input type="radio" name="jurusan" value="perhotelan" class="w3-check" required checked> Perhotelan
	        </span>
	        <span class="w3-padding">
	          <input type="radio" name="jurusan" value="tata boga" class="w3-check" required> Tata Boga
	        </span>
	      	@else
          	<span>
	          <input type="radio" name="jurusan" value="perhotelan" class="w3-check" required> Perhotelan
	        </span>
	        <span class="w3-padding">
	          <input type="radio" name="jurusan" value="tata boga" class="w3-check" required checked> Tata Boga
	        </span>
      	@endif
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="baju" style="line-height: 21px;">Ukuran Baju</label>
      </div>
      <div class="col-75">
        <select id="baju" onchange="select()" name="ukuran_baju" required=""oninvalid="this.setCustomValidity('Wajib Isi')" oninput="setCustomValidity('')">
          <option value="">--Pilih--</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="XL">XL</option>
          <option value="XXL">XXL</option>
          <option value="XXXL">XXXL</option>
          <option value="XXXXL">XXXXL</option>
          <option value="Jumbo">Jumbo</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Ukuran Celana</label>
      </div>
      <div class="col-75">
        <input type="text" id="ukurancelana" disabled="disabled" name="ukuran_celana" placeholder="Ukuran Celana" value="{{$data->ukuran_celana}}">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label>Upload Bukti Pembayaran</label>
      </div>
      <div class="col-75">
        <input type="file" name="gambar_konfirmasi">
        <br>
        <span class="alert-warning">maksimal ukuran photo 1 MB</span>
      </div>
    </div>
    <div class="row">
      <div class="c-12" style="margin-bottom: 10px">
        <div style="float: right;">
          <div class="g-recaptcha" data-sitekey="{{env('CAPCHA_KEY')}}"></div>
        </div>
      </div>
      <div class="c-12">
      <input type="submit" value="Simpan">
      </div>
      </div>
    </div>
    </form>
</div>
</div>
@endsection