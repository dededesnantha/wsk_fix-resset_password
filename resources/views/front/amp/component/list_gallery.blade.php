          @foreach($list as $row)
            <div class="card">    
                <amp-img alt="{{$row->judul}}"
                  src="{{url('galeri/580x370/'.$row->gambar)}}"
                  width="1.33"
                  height="1"
                  layout="responsive">
                </amp-img>  
            </div>
          @endforeach