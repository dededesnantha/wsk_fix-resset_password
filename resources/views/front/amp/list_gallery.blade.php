@extends('front.amp.layout')

@section('content')
<section class="block-section">
    <div class="p-0-5 text-center">
      <h1 class="text-center">
        @if($main['profile_website']->judul == $optiomation['main_title'])        
          Gallery
        @else
          {{@$optiomation['main_title']}}
        @endif
      </h1>

      @include('front.amp.component.list_gallery')

      <div>
        <?php echo $list->render(); ?>    
      </div>
    </div>
</section>

@endsection     