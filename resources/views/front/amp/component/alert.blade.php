@if (Session::has('alert-success'))
    <div class="alert alert-success">{{ Session::get('alert-success') }}</div>
@elseif (Session::has('alert-error'))
    <div class="alert alert-error">{{ Session::get('alert-error') }}</div>
@elseif (Session::has('alert-info'))
    <div class="alert alert-info">{{ Session::get('alert-info') }}</div>
@elseif (Session::has('alert-warning'))
    <div class="alert alert-warning">{{ Session::get('alert-warning') }}</div>
@endif

@if($errors->has())
    @foreach ($errors->all() as $error)        
        <div class="alert alert-error">{{ $error }}</div>
    @endforeach
@endif