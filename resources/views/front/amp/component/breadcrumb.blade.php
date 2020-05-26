<div class="w3-col m12 ">
    <div class="w3-margin" style="border: 2px solid #e8e8e8;border-top-width: 1px;background: #eee;">
        <div class="w3-container w3-padding-small" itemscope itemtype="http://schema.org/BreadcrumbList">
            @foreach($breadcrumb  as $row)
                <small class="w3-text-grey" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    @if($row['url'])                     
                        <a href="{{ $row['link'] }}" title="{{$row['name']}}" itemprop="item">
                            <span itemprop="name"> {{ $row['name'] }}</span>
                            <meta itemprop="position" content="{{ $row['position'] }}" />
                        </a> 
                    @else
                        <span itemprop="name"> {{ $row['name'] }}</span>
                        <meta itemprop="position" content="{{ $row['position'] }}" />
                    @endif
                    @if($row['next']) / @endif                    
                </small>
            @endforeach            
        </div>
    </div>
</div>