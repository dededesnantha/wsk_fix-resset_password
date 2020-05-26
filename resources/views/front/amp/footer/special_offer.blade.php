@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['spesial'] as $spesial)
	@if($spesial->page_judul == null)		
			<p><a href="{{url('amp/link').'/'.$spesial->product_slug}}" title="{{$spesial->product_judul}}" class="link-grey">{{$spesial->product_judul}}</a></p>	
	@else
			<p><a href="{{url('amp').'/'.$spesial->page_slug}}" title="{{$spesial->page_judul}}" class="link-grey">{{$spesial->page_judul}}</a></p>	
	@endif
@endforeach
		<br>