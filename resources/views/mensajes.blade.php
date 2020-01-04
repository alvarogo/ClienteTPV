@if(count($errors ?? []) > 0)
    @foreach($errors->all() as $error)
    <div style="clear: right;" class="alert  alert-danger">
        {{$error}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>

    @endforeach
@endif

@if(session('success'))
    <div style="clear: right;" class=" alert alert-success alert-dismissible fade show">
        {{session('success')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>

@endif

@if(session('error'))
    <div style="clear: right;" class="alert alert-danger">
        {{session('error')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>

@endif
