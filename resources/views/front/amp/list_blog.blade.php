@extends('front.amp.layout')

@section('content')
<section class="block-section">
    <div class="p-0-5 text-center">
      <h1 class="text-center">
        @if($main['profile_website']->judul == $optiomation['main_title'])
              All Blog
        @else
              Blog : {{$optiomation['main_title']}}
        @endif
        @include('front.amp.component.list_blog')

      <div>
        <?php echo $list->render(); ?>    
      </div>
    </div>
</section>

@endsection     