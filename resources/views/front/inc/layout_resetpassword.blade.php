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

  <style>
    td{
      border: none;
    }
  </style>
  
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

  
    @yield('content')

  

  <footer class="w3-row-padding w3-padding-32" style="z-index: 99;position: relative;background-color: #efefef;border-top: 1.5px solid #efefef;box-shadow: 0 -1px 1px rgba(200,200,200,0.3);" itemscope itemtype="http://schema.org/WPFooter">
    <div style="max-width:1100px;margin-top: 76px;margin:0 auto;">      
      

    </div>
  </footer>
  <div class="w3-light-grey w3-center w3-padding-small" style="z-index: 99;position: relative;">Powered by <span itemprop="copyrightHolder" itemscope itemtype="http://schema.org/Person"><a href="https://www.tayatha.com/" title="tayatha" target="_blank" class="w3-hover-opacity w3-text-white" itemprop="url"><span>tayatha</span> </a></span></div>  
</body>
</html>
