<!DOCTYPE html>
<html data-ng-app="app">
<head>
  <meta charset="utf-8" />
  <title>Tayatha</title>
  <meta name="theme-color" content="#27C24C" />
  <meta name="apple-mobile-web-app-status-bar-style" content="#27C24C">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex, nofollow">
  <meta name="google" content="notranslate" />
  <link rel="icon" type="image/png" href="{{asset('img/logo.png')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="{{asset('source')}}/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="{{asset('source')}}/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="{{asset('source')}}/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="{{asset('source')}}/css/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="{{asset('source')}}/css/font.css" type="text/css" />
  <link rel="stylesheet" href="{{asset('source')}}/css/app.css" type="text/css" />
  <link rel="stylesheet" href="{{asset('')}}vendor/angular-loading/build/loading-bar.min.css" type="text/css" />

  <script> 
    var baseurl = "{{ url('/')}}/" ;
    var capcha_key = "{{env('CAPCHA_KEY')}}" ;    
  </script>

</head>
<body ng-controller="AppCtrl">
  <div class="app" id="app" ng-class="{'app-header-fixed':app.settings.headerFixed, 'app-aside-fixed':app.settings.asideFixed, 'app-aside-folded':app.settings.asideFolded, 'app-aside-dock':app.settings.asideDock, 'container':app.settings.container}" ui-view></div>




  <!-- jQuery -->
  <script src="{{asset('')}}vendor/jquery/jquery.min.js"></script>

  <!-- Angular -->
  <script src="{{asset('')}}vendor/angular/angular.min.js"></script>
  
  <script src="{{asset('')}}vendor/angular/angular-animate/angular-animate.min.js"></script>
  <script src="{{asset('')}}vendor/angular/angular-cookies/angular-cookies.min.js"></script>
  <script src="{{asset('')}}vendor/angular/angular-resource/angular-resource.min.js"></script>
  <script src="{{asset('')}}vendor/angular/angular-sanitize/angular-sanitize.min.js"></script>
  <script src="{{asset('')}}vendor/angular/angular-touch/angular-touch.min.js"></script>

  <!-- Vendor -->
  <script src="{{asset('')}}vendor/angular/angular-ui-router/angular-ui-router.js"></script> 
  <script src="{{asset('')}}vendor/angular/ngstorage/ngStorage.js"></script>
  <script src="{{asset('')}}vendor/angular-loading/build/loading-bar.min.js"></script>
  <script src="{{asset('')}}vendor/angular/ng-google-recaptcha/ng-google-recaptcha.js"></script>
  
  <!-- bootstrap -->
  <script src="{{asset('')}}vendor/angular/angular-bootstrap/ui-bootstrap-tpls.js"></script>
  <!-- lazyload -->
  <script src="{{asset('')}}vendor/angular/oclazyload/ocLazyLoad.js"></script>
  <!-- translate -->
  <script src="{{asset('')}}vendor/angular/angular-translate/angular-translate.js"></script>
  <script src="{{asset('')}}vendor/angular/angular-translate/loader-static-files.js"></script>
  <script src="{{asset('')}}vendor/angular/angular-translate/storage-cookie.js"></script>
  <script src="{{asset('')}}vendor/angular/angular-translate/storage-local.js"></script>

  <!-- App -->
  <script src="{{asset('')}}js/app.js"></script>
  <script src="{{asset('')}}js/config.js"></script>
  <script src="{{asset('')}}js/config.lazyload.js"></script>
  <script src="{{asset('')}}js/config.router.js"></script>
  <script src="{{asset('')}}js/main.js"></script>
  <script src="{{asset('')}}js/services/ui-load.js"></script>
  <script src="{{asset('')}}js/filters/fromNow.js"></script>
  <script src="{{asset('')}}js/directives/setnganimate.js"></script>
  <script src="{{asset('')}}js/directives/ui-butterbar.js"></script>
  <script src="{{asset('')}}js/directives/ui-focus.js"></script>
  <script src="{{asset('')}}js/directives/ui-fullscreen.js"></script>
  <script src="{{asset('')}}js/directives/ui-jq.js"></script>
  <script src="{{asset('')}}js/directives/ui-module.js"></script>
  <script src="{{asset('')}}js/directives/ui-nav.js"></script>
  <script src="{{asset('')}}js/directives/ui-scroll.js"></script>
  <script src="{{asset('')}}js/directives/ui-shift.js"></script>
  <script src="{{asset('')}}js/directives/ui-toggleclass.js"></script>
  <script src="{{asset('')}}js/directives/ui-validate.js"></script>
  <script src="{{asset('')}}js/controllers/bootstrap.js"></script>
  <!-- Lazy loading -->

  

</body>
</html>