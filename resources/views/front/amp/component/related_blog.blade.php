      <div class="m-b-20 p-10">
          <h2>{{@$single->judul_cat}}</h2>
        </div>
        @foreach($related as $row)
          <div class="card">
            <a href="{{url('amp/blog').'/'.$row->slug}}" title="{{$row->judul}}">
              <amp-img alt="{{$row->judul}}"
                src="{{asset('gambar/580x370').'/'.$row->gambar}}"
                width="1.33"
                height="1"
                layout="responsive">
              </amp-img>
            </a>
            <a href="{{url('amp/blog').'/'.$row->slug}}" title="{{$row->judul}}" class="link-title">
              <h3>{{$row->judul}}</h3>
            </a>    
          </div>
        @endforeach  