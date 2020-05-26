@extends('front.inc.layout_resetpassword')
@section('content')
<div class="container">
  <div style="text-align: center;">
    <h4>Lupa Password :</h4>
  </div>
  <div class="c-12">
  @include('front.component.alert')
    <form action="{{ url('/reset_password_without_token') }}" method="POST" enctype="multipart/form-data" id="my-form">
      {{ csrf_field() }}
	    <div class="row">
	      <div class="col-25" style="text-align: center">
	        <label>Nis :</label>
	      </div>
	      <div class="col-75">
	        <input class="form-control" type="text" value="{{ old('nis') }}" required="" placeholder="Nis Siswa" name="nis"
	        oninvalid="this.setCustomValidity('Wajib Diisi')"
	        oninput="setCustomValidity('')">
	      </div>
	    </div>
    	<div class="row">
      		<div class="c-12" style="margin-bottom: 10px">
      		</div>
      		<div class="c-12">
      			<input type="submit" value="Submit">
      		</div>
    	</div>
    </form>
   </div>
</div>
@endsection