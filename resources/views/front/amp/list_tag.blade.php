@extends('front.amp.layout')

@section('content')
  <section class="block-section">
      <div class="p-0-5 text-center">
        <h1 class="text-center">
          {{@$optiomation['main_title']}}          
        </h1>

        @include('front.amp.component.list_tag')    
          
        <div>
          <?php echo $list->render(); ?>    
        </div>
      </div>
  </section>
@endsection     