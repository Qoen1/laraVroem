@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    <br>
@endif
@if($errors->any())
    <div class="alert alert-danger ">
        {{ $errors->all()[0] }}
    </div>
    <br>
@endif
@elseif(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif
