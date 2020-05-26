    <span class="w3-right">
        <span>Contact : </span>
        @foreach($main['contact'] as $row)    
            @if($row['role'] != 0)
                <a href="{{$row['link']}}" title="{{$row['title']}}" target="_blank"><img src="{{$row['img']}}" alt="{{$row['title']}}" width="35px"></a>
            @endif
        @endforeach
    </span>