@extends('front.layout')

@section('script')
@endsection
@section('content')    
  <div class="w3-row " style="max-width:1200px;margin-top: 46px;margin:0 auto">
    <div class="w3-container w3-center w3-padding" style="margin-top: 50px"></div>    
    <div class="w3-col l8 s12">
      <h2 class="w3-center w3-padding-48 "><span class="w3-tag w3-light-grey w3-wide w3-card-2">
        Result Search
      </span></h2>
      @include('front.component.breadcrumb')

      <div class="w3-row-padding " style="max-width:1100px;margin-top: 46px;margin:0 auto; padding-bottom: 50px;">
        @include('front.component.search')
      </div>
      
      <div class="w3-center w3-padding-32">  
        <?php echo $list->render(); ?>                
      </div>
    </div>  
    @include('front.inc.sidebar')    
  </div>
@endsection