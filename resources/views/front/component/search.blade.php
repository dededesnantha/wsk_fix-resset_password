@foreach($list as $row)
      <div class="w3-col l6 m6 w3-margin-bottom ">
        <div class="w3-card-4">
          <div class="w3-display-container">
            <a href="{{url('link/'.$row->slug)}}" title="{{$row->judul}}">
              <img src="{{asset('gambar/376x325').'/'.$row->gambar}}" alt="{{$row->judul}}" style="width:100%">
            </a>
            <a href="{{url('link/'.$row->slug)}}" title="{{$row->judul}}">
              <div class="w3-display-bottommiddle w3-light-grey w3-block w3-padding-small"><h5 id="{{str_replace(' ','_',$row->judul)}}">{{$row->judul}}</h5></div>
            </a>
          </div>
        </div>
      </div>
@endforeach