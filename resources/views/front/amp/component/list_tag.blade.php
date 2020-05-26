    @foreach($list as $row)
        @if($row->judul_product == '')
          <div class="card">
            <a href="{{url('amp/blog/'.$row->slug_blog)}}" title="{{$row->judul_blog}}">
              <amp-img alt="{{$row->judul_blog}}"
                src="{{url('gambar/580x370/'.$row->gambar_blog)}}"
                width="1.33"
                height="1"
                layout="responsive">
              </amp-img>
            </a>
            <a href="{{url('amp/blog/'.$row->slug_blog)}}" title="{{$row->judul_blog}}" class="link-title">
              <h3>{{$row->judul_blog}}</h3>
            </a>
            <div class="p-10">            
              {{ preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6',substr(strip_tags($row->deskripsi_blog), 0,150))}}..
            </div>
          </div>
        @elseif($row->judul_blog == '')
          <div class="card">
            <a href="{{url('amp/link/'.$row->slug_product)}}" title="{{$row->judul_product}}">
              <amp-img alt="{{$row->judul_product}}"
                src="{{url('gambar/580x370/'.$row->gambar_product)}}"
                width="1.33"
                height="1"
                layout="responsive">
              </amp-img>
            </a>
            <a href="{{url('amp/link/'.$row->slug_product)}}" title="{{$row->judul_product}}" class="link-title" ">
              <h3>{{$row->judul_product}}</h3>
            </a>
            <div class="p-10">            
              {{ preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6',substr(strip_tags($row->deskripsi_product), 0,150))}}..
            </div>
          </div>
        @endif
    @endforeach