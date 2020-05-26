@if($row->judul != '')
		<h3 class="font-secondary color-white" >{{$row->judul}}</h3>
@endif		
		<p class="color-white text-left link-grey" >{{ $main['label']['Address'] }} : {{$main['profile_website']->alamat}}</p>		
