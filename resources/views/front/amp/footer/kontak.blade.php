	@if($row->judul != '')		
		<h3>{{$row->judul}}</h3>
	@endif
	<div>
		@foreach($main['contact'] as $contacts)    
			<p>	
				@if($contacts['role'] != 0)
					@if(!$contacts['image_null'])
						<amp-img src="{{$contacts['img']}}" alt="{{$contacts['title']}}" width="30px" height="30px"></amp-img>										
					@endif
					{{$contacts['title']}} : <a href="{{$contacts['link']}}" title="{{$contacts['title']}}" target="_blank" {{$contacts['itemprop']}}>{{$contacts['id']}}</a>		
				@else
					@if(!$contacts['image_null'])						
						<amp-img src="{{$contacts['img']}}" alt="{{$contacts['title']}}" width="30px" height="30px"></amp-img>
					@endif
					{{$contacts['title']}} : <span {{$contacts['itemprop']}}>{{$contacts['id']}}</span>
				@endif
			</p>
		@endforeach
	</div>
	<p >{{ $main['label']['Address'] }} : <span itemprop="streetAddress">{{$main['profile_website']->alamat}} </span></p>
	<br>	
		