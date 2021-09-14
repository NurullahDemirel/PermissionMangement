@if(count($errors)>0)
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
            <li>{{$err}}</li>
        @endforeach
    </div>
@endif

