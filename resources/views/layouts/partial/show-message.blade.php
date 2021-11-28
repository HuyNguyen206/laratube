@if($error = session('error'))
    <div class="alert alert-danger">
        {{$error}}
    </div>

@endif
@if($success = session('success'))
    <div class="alert alert-success">
        {{$success}}
    </div>

@endif
