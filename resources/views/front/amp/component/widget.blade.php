        @foreach($widget as $row)
          <div class="widget">
            <h4>{{$row->name}}</h4>
            <div>
              <?= preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6',$row->description) ?>
            </div>
          </div>
        @endforeach