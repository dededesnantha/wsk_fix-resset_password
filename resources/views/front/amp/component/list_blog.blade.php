        @foreach($list as $row)
          <div class="card">
            <a href="{{url('amp/blog/'.$row->slug)}}" title="{{$row->judul}}">
              <amp-img alt="{{$row->judul}}"
                src="{{url('gambar/580x370/'.$row->gambar)}}"
                width="1.33"
                height="1"
                layout="responsive">
              </amp-img>
            </a>
            <a href="{{url('amp/blog/'.$row->slug)}}" title="{{$row->judul}}" class="link-title">
              <h3>{{$row->judul}}</h3>
            </a>
            <div class="p-10">
              <?= preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6',substr(strip_tags($row->deskripsi), 0,150)) ?>
            </div>
          </div>
        @endforeach