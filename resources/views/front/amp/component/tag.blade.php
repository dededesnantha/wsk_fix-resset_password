    <div class="m-b-20 m-t-20 p-10">
        <small>Tag :</small>
        @foreach($tag as $tags)
            <a href="{{url('amp/tag').'/'.$tags->slug}}" title="{{$tags->judul}}" class="tag"><small >{{$tags->judul}}</small></a>
        @endforeach
    </div>