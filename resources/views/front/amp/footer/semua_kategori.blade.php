
@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['kategori'] as $kategori)
		<p><a href="{{url('amp/category').'/'.$kategori->slug}}" title="{{$kategori->judul}}" class="link-grey">{{$kategori->judul}}</a></p>
@endforeach
		<br>