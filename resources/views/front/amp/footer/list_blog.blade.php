@if($row->judul != '')
		<h3>{{$row->judul}}</h3>
@endif	
@foreach($main['list_blog_footer'] as $list_blogs)
			<p><a href="{{url('blog').'/'.$list_blogs->slug}}" title="{{$list_blogs->judul}}" class="link-grey"> {{$list_blogs->judul}}</a></p>
@endforeach        
		<br>
