@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['social_media'] as $social_media)
		<a href="{{ $social_media['link'] }}" title="{{ $social_media['title'] }}"><amp-img src="{{ $social_media['img'] }}" alt="{{ $social_media['title'] }}" width="40px" height=40px></amp-img></a>
@endforeach
<br>