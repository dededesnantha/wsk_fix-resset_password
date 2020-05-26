<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('front/template1')}}/grid.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>  
    <script src="{{asset('front')}}/jquery-3.1.1.min.js" type="text/javascript"></script>
    <title>Pendaftar Ulang</title>
    <style>
        /* @extend display-flex; */
    display-flex {
      display: flex;
      display: -webkit-flex; }

    /* @extend list-type-ulli; */
    list-type-ulli {
      list-style-type: none;
      margin: 0;
      padding: 0; }

    a:focus, a:active {
      text-decoration: none;
      outline: none;
      transition: all 300ms ease 0s;
      -moz-transition: all 300ms ease 0s;
      -webkit-transition: all 300ms ease 0s;
      -o-transition: all 300ms ease 0s;
      -ms-transition: all 300ms ease 0s; }

    input, select, textarea {
      outline: none;
      appearance: unset !important;
      -moz-appearance: unset !important;
      -webkit-appearance: unset !important;
      -o-appearance: unset !important;
      -ms-appearance: unset !important; }

    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button {
      appearance: none !important;
      -moz-appearance: none !important;
      -webkit-appearance: none !important;
      -o-appearance: none !important;
      -ms-appearance: none !important;
      margin: 0; }

    input:focus, select:focus, textarea:focus {
      outline: none;
      box-shadow: none !important;
      -moz-box-shadow: none !important;
      -webkit-box-shadow: none !important;
      -o-box-shadow: none !important;
      -ms-box-shadow: none !important; }

    img {
      max-width: 100%;
      height: auto; }

    figure {
      margin: 0; }

    p {
      margin-bottom: 0px; }

    h2, h1, h3, h4, h5, h6{
      line-height: 2.5;
      margin: 0;
      padding: 0;
      font-weight: bold;
      color: #222;
      font-family: 'Open Sans', sans-serif;
      font-size: 24px;
      text-align: center; }

    .clear {
      clear: both; }

    body {
      font-size: 14px;
      line-height: 1.8;
      color: #222;
      background: #f2f2f2;
      font-weight: 600;
      font-family: Poppins;
      margin: 0px; 
      font-family: 'Open Sans', sans-serif;}

    .main {
      padding: 50px 0;
      position: relative; }


    .container {
      width: 520px;
      background: #fff;
      margin: 0 auto;
      box-shadow: 0px 10px 9.9px 0.1px rgba(0, 0, 0, 0.05);
      -moz-box-shadow: 0px 10px 9.9px 0.1px rgba(0, 0, 0, 0.05);
      -webkit-box-shadow: 0px 10px 9.9px 0.1px rgba(0, 0, 0, 0.05);
      -o-box-shadow: 0px 10px 9.9px 0.1px rgba(0, 0, 0, 0.05);
      -ms-box-shadow: 0px 10px 9.9px 0.1px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
      -moz-border-radius: 10px;
      -webkit-border-radius: 10px;
      -o-border-radius: 10px;
      -ms-border-radius: 10px; }

    .sign-up-content {
      padding: 40px 60px 32px 60px;
      position: relative;
      z-index: 99; }

    input {
      border: solid 2px #ebebeb;
      box-sizing: border-box;
      width: 100%;
      font-weight: 700;
      font-size: 14px;
      font-family: 'Open Sans', sans-serif;
      padding: 16px 30px 16px 90px; }

    .form-textbox {
      position: relative; }
      .form-textbox label {
        position: absolute;
        left: 28px;
        top: 50%;
        transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        -o-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        font-weight: 600;
        color: #888;
        font-size: 14px; }


    .label-agree-term {
      color: #888; }

    .term-service {
      color: #1da0f2;
      text-decoration: none; }
      .term-service:hover {
        text-decoration: underline; }

    .submit {
      background: #1da0f2;
      color: #FFF;
      border: none;
      padding: 15px 20px;
      font-size: 13px;
      font-weight: 600;
      font-family: Poppins;
      border-radius: 5px;
      -moz-border-radius: 5px;
      -webkit-border-radius: 5px;
      -o-border-radius: 5px;
      -ms-border-radius: 5px; }
      .submit:hover {
        background: #0c85d0; }

    .loginhere {
      text-align: center;
      color: #888;
      margin-top: 63px; }

      #input{
        padding-left: 210px;
      }

    .loginhere-link {
      color: #1da0f2;
      text-decoration: none; }
      .loginhere-link:hover {
        text-decoration: underline; }

    input:-webkit-autofill {
      -webkit-box-shadow: 0 0 0 30px white inset; }

    @media screen and (max-width: 768px) {
      .container {
        width: calc( 100% - 30px);
        max-width: 100%; } }
    @media screen and (max-width: 575px) {
      .sign-up-content {
        padding: 40px 1px 32px 1px; }
      }
    @media screen and (max-width: 400px) {
      .form-textbox label {
        left: 3px; }

      #input{
        padding: 14px 2px 13px 181px;
      }
      input {
        padding: 16px 1px 14px 60px; } }

        .form-control{
          padding: 10px !important;
          width: 30%;
        }
    </style>
</head>
<body>

    <div class="main">
        <div class="container">
            <div class="sign-up-content">
                    <h2 class="form-title">Pendaftaran Ulang</h2>
                    <div style="margin: 0 auto;text-align: center;">
                    <img src="{{url('image/logo')}}/logo.jpg" alt="logo" style="width:28%;padding: 10px 0 0 10px">
                    </div>
                    @if (Session::has('alert-success'))
                    <div style="background-color: #1b923fb5;color: #fff;padding: 5px;margin: 5px">{{ Session::get('alert-success') }}</div>
                    @elseif (Session::has('alert-error'))
                    <div style="background-color: #ff0000b5;color: #fff;padding: 5px;margin: 5px">{{ Session::get('alert-error') }}</div>
                    @endif
                    @if($errors->has())
                    @foreach ($errors->all() as $error)        
                    <div style="background-color: #ff0000b5;color: #fff;padding: 5px;margin: 5px">{{ $error }}</div>
                    @endforeach
                    @endif
                <form action="{{ url('daftar/ulang') }}" method="POST" enctype="multipart/form-data" class="signup-form" >
                  {{ csrf_field() }}
                    <div class="form-textbox" style="margin-bottom: 10px">
                        <label>Nomer Registrasi WSKPD - </label>
                        <input type="number" id="input" name="no_registrasi"/>
                    </div>


                    <div class="form-textbox" style="margin-bottom: 20px">
                        <label>Kode </label>
                        <input type="number" name="kode"/>
                    </div>

                      <!-- <div class="row" style="margin-top: 20px">
                      <label for="mathgroup" style="margin-top: 10px; margin-right: 10px">{{ app('mathcaptcha')->label() }}</label>
                      <div style="display: block;">
                       {!! app('mathcaptcha')->input(['class' => 'form-control', 'id' => 'mathgroup', 'type' => 'number']) !!}
                       @if ($errors->has('mathcaptcha'))
                       <span class="help-block">
                        <span style="background-color: #ff0000b5;color: #fff;padding: 5px;"><i>{{ $errors->first('mathcaptcha') }}</i></span>
                      </span>
                      @endif
                    </div>
                        
                      </div> -->
                      <div class="form-textbox">
                        <div class="g-recaptcha" data-sitekey="{{env('CAPCHA_KEY')}}"></div>
                      </div>
                    <div class="form-textbox" style="margin-top: 27px;margin-bottom: 45px;">
                        <input type="submit" value="Submit" style="padding: 15px 30px 16px 17px;">
                        <!-- <input type="submit" name="submit" id="submit" class="submit" value="Create account" /> -->
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>
</html>