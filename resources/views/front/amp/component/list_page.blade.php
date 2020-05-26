    @foreach($list_page as $row)
      <div class="list_page">        
          <div class="image">
            <a href="{{ url('amp/'.$row->slug) }}" title="{{$row->judul}}">
              <amp-img alt="{{$row->judul}}"
                src="{{asset('gambar/580x370').'/'.@$row->gambar}}"
                width="1.33"
                height="1"
                layout="responsive">
              </amp-img>              
            </a>
          </div>
          <div class="article">
            <a href="{{ url('amp/'.$row->slug) }}" title="{{$row->judul}}">
              <h4 class="font-secondary color-primary">{{$row->judul}}</h4>
            </a>
            <p>
              <?= substr(strip_tags($row->deskripsi), 0,100) ?>..
            </p>            
          </div>        
      </div>
    @endforeach