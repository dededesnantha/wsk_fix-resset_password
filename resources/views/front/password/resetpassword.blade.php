@extends('front.inc.layout_resetpassword')
@section('content')
<div class="container">
  <div style="text-align: center;">
    <h4>Reset Password :</h4>
    <span>hallo <b>{{$getToken->name }}</b>, silahkan isi password baru anda</span>
  </div>
  <div class="c-12">
  @include('front.component.alert')
    <form action="{{ url('update_password/'.$getToken->token) }}" method="POST" enctype="multipart/form-data" id="my-form">
      {{ csrf_field() }}
	    <div class="row">
	      <div class="col-25">
	        <label>Password Baru:</label>
	      </div>
	      <div class="col-75">
	        <input class="form-control" type="password" value="{{ old('password') }}" required="" placeholder="Password Baru" name="password"
	        oninvalid="this.setCustomValidity('Wajib Diisi')"
	        oninput="setCustomValidity('')">
	      </div>
	    </div>
      <div class="row">
        <div class="col-25">
          <label>Konfirmasi Password:</label>
        </div>
        <div class="col-75">
          <input class="form-control" type="password" value="{{ old('konfirpasswrod') }}" required="" placeholder="Konfirmasi Password" name="konfirpasswrod"
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