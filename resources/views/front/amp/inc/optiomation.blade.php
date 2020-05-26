@if(!empty($optiomation))
    <title>{{$optiomation['title']}}</title>
    <meta name="description" content="{{$optiomation['description']}}">      
    <meta name="keywords" content="{{$optiomation['keyword']}}">
    <meta name="author" content="{{$optiomation['author']}}">
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="{{$optiomation['title']}}" />
    <meta property="og:description"        content="{{$optiomation['description']}}" />
    <meta property="og:image"              content="{{$optiomation['image']}}" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="450" />
    <meta property="og:site_name" content="{{$optiomation['sitename']}}" />
    <meta property="og:url" content="{{Request::fullUrl()}}"/>
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="{{$optiomation['description']}}" />
    <meta name="twitter:title" content="{{$optiomation['title']}}" />
    <meta name="twitter:image" content="{{$optiomation['image']}}" />
    
    @if(!empty($optiomation['single_optiomation']))
        @foreach($optiomation['single_optiomation']['tag'] as $row)
        <meta property="article:tag" content="{{$row->judul}}" />
        @endforeach
        <meta property="article:section" content="{{$optiomation['single_optiomation']['judul_cat']}}" />
        <meta property="article:published_time" content="{{ $optiomation['single_optiomation']['created_at'] }}" />
        <meta property="article:modified_time" content="{{ $optiomation['single_optiomation']['updated_at'] }}" />
        <meta property="og:updated_time" content="{{ $optiomation['single_optiomation']['updated_at'] }}" />  
    @endif
@endif