@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif
@foreach($main['menu'] as $key)  
@if($key->link == 'kategori')    
@else
		<p><a href="{{ str_replace(url(''), url('').'/amp', $key->link) }}" title="{{$key->judul}}" class="link-grey">{{$key->judul}}</a></p>	
@endif      
 @endforeach 
		<br>