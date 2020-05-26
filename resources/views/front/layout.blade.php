<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f2f2f2" />
  <link rel="icon" type="image/png" href="{{url('image/logo')}}/logo.png">
  <link rel="stylesheet" href="{{asset('front/template1')}}/style.css">
  <link rel="stylesheet" href="{{asset('front/template1')}}/grid.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="{{asset('front/template1')}}/nav.css">  
  @include('front.component.template_style')
  <link rel="amphtml" href="{{ str_replace(url(''), url('').'/amp',Request::fullUrl() ) }}">
  
@yield('script')
</head>

<body itemscope itemtype="http://schema.org/WebPage">

  <div class="container-fluit">
  <div style="background-color: #ffff;border-bottom: 2px solid #e4e4e4">
  <div class="row">
    <div class="c-4 c-sm-4">
    </div>
    <div class="c-4 c-sm-4">
      <a href="{{url()}}" title="">
      <div style="text-align: center;">
       <img src="{{url('image/logo')}}/logo.png" alt="logo" style="width:20%;padding: 10px 0 0 10px">
       <br>
       <span style="color: #374bfd;font-size: 30px;font-weight: bold;line-height: 46px;text-decoration: none;text-shadow: 1px 1px 1px #000;">
         SMK Werdhi Sila Kumara
       </span>
      </div>
      </a>
    </div>
    <div class="c-4 c-sm-4">
    </div>
  </div>
    
  </div>
    
  </div>

  <div class="row" style="padding: 0; margin: 0;">
    <div class="c-4 c-sm-4" style="padding: 10px 70px">
      <div class="row">
        <div class="c-6" style="margin-bottom: 30px">
          <a href="{{url()}}" title="">
          <div style="text-align: center; max-width: 226px;height: 116px;margin: 0 auto;">
            <div style=" padding-top: 26px">
              <i class="fa fa-home" aria-hidden="true" style="font-size: 50px;"></i>
            </div>
            <span>HOME</span>
          </div>
        </a>
        </div>
        <div class="c-6">
        <a href="{{url('daftar/ulang')}}" title="">
          <div style="background-color: #067834;text-align: center; max-width: 226px;height: 116px;margin: 0 auto;">
            <div style=" padding-top: 26px">
              <i class="fa fa-user" aria-hidden="true" style="font-size: 30px; color: #fff"></i>
            </div>
            <span style="color: #fff">Pendaftaran Ulang</span>
          </div>
        </a> 
        </div>
        
      </div>
    </div>
    <div class="c-4 c-sm-4" style="padding: 10px 70px">
      <a href="{{url('Rincian/Pembayaran')}}" title="">
        <div style="background-color: #3c6c84;text-align: center; max-width: 240px;margin: 0 auto;">
          <div style=" padding-top: 20px">
            <i class="fa fa-file-text-o" aria-hidden="true" style="font-size: 30px; color: #fff"></i>
          </div>
          <span style="color: #fff">Rincian Penitipan Pembayaran</span>
        </div>
      </a>
    </div>
    <div class="c-4 c-sm-4" style="padding-top: 30px; padding-left: 30px;">
      <span style="margin-left: 40px">Pencarian Data Calon Siswa Baru</span>
      <form method="get" action="{{url('search')}}" class="row">
        <span style="margin-top: 10px;">WSKPD - </span>
        <div style="display: block;">
          <input type="text" id="search" name="search" placeholder="Nomer Registrasi" align="right">
        </div>
            <button type="submit" style="color:#9EA9AC;background: #9EA9AC;font-size: 20px;font-weight: 300;border: 2px solid;border-radius: 2px;height: 40px;padding: 9px 10px;margin-top: 5px;padding-top: 5px;"><i class="fa fa-search" aria-hidden="true" style="font-size: 20px; color: #fff"></i></button>
      </form>
    </div>
  </div>
  
    @yield('content')

  

  <footer class="w3-row-padding w3-padding-32" style="z-index: 99;position: relative;background-color: #efefef;border-top: 1.5px solid #efefef;box-shadow: 0 -1px 1px rgba(200,200,200,0.3);" itemscope itemtype="http://schema.org/WPFooter">
    <div style="max-width:1100px;margin-top: 76px;margin:0 auto;">      
      

    </div>
  </footer>
  <div class="w3-light-grey w3-center w3-padding-small" style="z-index: 99;position: relative;">Powered by <span itemprop="copyrightHolder" itemscope itemtype="http://schema.org/Person"><a href="https://www.tayatha.com/" title="tayatha" target="_blank" class="w3-hover-opacity w3-text-white" itemprop="url"><span>tayatha</span> </a></span></div>  
</body>
</html>
