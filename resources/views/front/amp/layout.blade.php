<!doctype html>
<html amp lang="{{ $main['label']['en'] }}">
  <head>
  	@if(trim($main['profile_website']->google_webmaster) != '')
	  <?= $main['profile_website']->google_webmaster; ?>
	@endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta name="theme-color" content="#696969" />
	<meta name="apple-mobile-web-app-status-bar-style" content="#696969">

	@include('front.amp.inc.optiomation')
	<link rel="icon" type="image/png" href="{{asset('image').'/'.$main['profile_website']->logo}}">
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="canonical" href="{{ str_replace(url('').'/amp', url(''),Request::fullUrl() ) }}">

    	@if(trim($main['profile_website']->google_analytics) != '')
			<?= $main['profile_website']->google_analytics; ?>
		@endif
		@if(trim($main['profile_website']->facebook_pixel) != '')
			<?= $main['profile_website']->facebook_pixel; ?>
		@endif

	<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <style amp-custom>
	    *{box-sizing:inherit;}
	    html{box-sizing:border-box;-ms-overflow-style:scrollbar;line-height: 1.15; }
	    body{width: 100%;font-family:'Quicksand';line-height: 1.5;background: #fff;overflow: hidden;}
	    main{max-width: 580px;margin: 0 auto;background: #fff}
      a{text-decoration: none;color: #247aff;}
      h1,h2,h3,h4,h5,h6{margin: 10px;}
      footer{color: #3c3c3c;text-align: left;padding:10px 20px;border-top:1.5px solid #e3e3e3;margin-top: 40px;margin-bottom: 20px}
      footer:before{content: "";width: 95%;display: block;height: 2px;background: #e3e3e3;margin: auto;margin-top: 10px;margin-bottom: 35px;}
      p{font-size: 14.7px;line-height: 1.8;}
	    #nav > a{display: none;text-decoration: none;color: #fff;font-size: 16px;}
	    #nav li{position: relative;}
	    #nav > ul{height: 3.75em;}
	    #nav > ul > li{width: 25%;height: 100%;float: left;text-align: center;}
	    #nav > ul > li a{text-decoration: none;color: #fff;font-size: 14px;padding: 0.5rem;display: block;}
	    #nav > ul > li a:hover{background: #fff;color: #000}
	    #nav li ul{display: none;position: absolute;top: 100%;list-style: none;}
	    #nav li:hover ul{display: contents;list-style: none;}
	    #nav{position: relative;background: #464646;padding: 12px 14px;z-index: 20;border-bottom: 1px solid #585858;box-shadow: 0 1px 1px rgba(100,100,100,0.3);}
	    #nav > a{text-decoration: none;color: #fff;font-size: 16px;}
	    #nav:not( :target ) > a:first-of-type,#nav:target > a:last-of-type{display: block;text-decoration: none;color: #fff;font-size: 16px;}
	    #nav > ul{height: auto;display: none;position: absolute;left: 0;right: 0;background: #696969;top: 30px}
	    #nav:target > ul{display: block;padding: 0.5rem 0px;list-style: none;}
	    #nav > ul > li{width: 100%;float: none;}
	    #nav li ul{position: static;}
      .btn{text-decoration: none;padding: 7px 25px;background: #545454;color: #fff;border-radius: 3px;font-size: 14px;letter-spacing: 2px;box-shadow: 0 5px 7px rgba(220,220,220,1);transition: 0.1s}
	    .btn:hover{color: #545454;background: #eee;font-weight: 600;box-shadow: 0 2px 7px rgba(0,0,0,0.3)}
	    .pagination{display: inline-block;padding-left: 0;margin: 20px 0;border-radius: 4px;}
		.pagination > li {display: inline;}
		.pagination > li > a, .pagination > li > span {position: relative;float: left;padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #696969;text-decoration: none;background-color: #fff;border: 1px solid #fff;}
		.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {z-index: 2;color: #fff;cursor: default;background-color: #696969;border-color: #428bca;}
		.tag{text-decoration: none;color: #fff;padding: 0px 5px;background: #929292;border: 1px solid #949494;border-radius: 3px;font-size: 14px;transition: 0.1s;}
    .tag:hover{background: #797676}
		.text-white{color:#fff}
		.text-center{text-align: center}
		.no-decoration{text-decoration: none;}
    .link-grey{text-decoration: none;color: #666666;font-weight: 500;transition: 0.1s; padding: 4px 10px;border:1.5px solid transparent;}
    .link-grey:before{content: "";display: inline-flex;width: 10px;background: #eee;height: 10px;margin-right: 11px;border-radius: 10px;}
		.link-grey:hover{background: #e3e3e3;border:0.5px solid #efefef;border-radius: 4px}
		.block-section{display: block;margin-bottom: 30px}	}
		.p-0-5{padding:0 5px}
		.p-0-10{padding:0 10px}
		.p-0-15{padding:0 15px}
		.m-t-20{margin-top: 20px}
		.m-b-20{margin-bottom: 30px}
		.m-b-30{margin-bottom: 30px}
		.p-10{padding: 10px}
		.card{padding: 5px;margin-bottom: 10px;border: 1px solid #efefef;box-shadow: 0 1.5px 2px rgba(200,200,200,0.4)}
		.link-title{text-decoration: none;color: #464646;text-align: center;}
		.share{bottom: 10px;position: relative;}
		.share-email{background-color: #F14336}
		.share-wa{background-color: #65BC54}
		.share-line{background-color: #3FD037}
		.share-facebook{background-color: #3B5998}
		.share-twitter{background-color: #55ACEE}
		.widget{border:1px solid #efefef;margin-top: 20px;font-size: 15px;}
		.widget h4{margin: 0;color:#000;padding: 3px;color: #fff;background: #696969;text-align: center;}
		.widget div{padding: 0 0.5rem}
		.list_page{display: flex;border: 2px solid #efefef;margin-bottom: 10px}
		.list_page .image{width: 40%}
		.list_page .article{width: 60%;padding: 0 15px}
		.list_page .article a{text-decoration: none;}
		.list_page .article h4{margin-bottom: 10px;margin-top: 15px;margin-left: 0px;}
    </style>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    @yield('script')
  </head>
  <body>
    <main>
		<nav id="nav" role="navigation">
			<a href="#nav" title="Show navigation"><amp-img src="{{asset('img/menu.png')}}" width="25px" height="25px"></amp-img></a>
			<a href="#" title="Hide navigation">Close</a>
			<ul>
				@foreach($main['menu'] as $row)
						<li>
				@if($row->link == 'kategori')
							<a href="#" title="{{$row->judul}}">
				@else
							<a href="{{ str_replace(url(''), url('').'/amp', $row->link) }}" title="{{$row->judul}}">
				@endif
							{{$row->judul}}
							</a>
				@if($row->link == 'kategori')
							<ul>
				@foreach($main['parent'][$row->id_parent] as $key)
									<li ><a href="{{ str_replace(url(''), url('').'/amp', url('link').'/'.$key->slug) }}" title="{{$key->judul}}">{{$key->judul}}</a></li>
				@endforeach
							</ul>
				@endif
						</li>
				@endforeach
			</ul>
		</nav>
		@yield('content')
		<footer>
			<div>
				@foreach($main['menu_footer'] as $row)
					<a href="{{ str_replace(url(''), url('').'/amp',$row->link )}}" title="{{$row->judul}}" >{{$row->judul}}</a> /
				@endforeach
				<br>
			</div>
			<div>
				@for ($i = 1; $i < 3; $i++)

						@foreach($main['footer_kolom'.$i] as $row)
							@if ($row->template != null)
                <div>
					@include($row->template)
                </div>
							@endif
						@endforeach

				@endfor
			</div>
			<div class="text-center">
				<a href="{{ url('') }}" title="Normalpage" class="btn"><small>Go to Default Page</small></a>
				<br>
        <br>
				<p>
					Powered by <strong><a href="https://www.tayatha.com/" title="tayatha" target="_blank" >tayatha</a></strong>
				</p>
			</div>
		</footer>
    </main>
  </body>
</html>
