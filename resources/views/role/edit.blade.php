@extends('layouts.app')
@section('content')
    <div class="container">
        @include('errors.control')
        <label class="row">{{$kisi->name}}'s Permissions</label>

        <form class="row" action="{{route('permissions-edit',$kisi->id)}}" method="post">
            @csrf
            <div class="col-md-8 d-flex   bg-danger">
                <div class="d-flex flex-column flex-wrap" style="height: 100px;">
                    @foreach($izinler as $obje)

                        @if(in_array($obje->name,$enable))
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{$obje->name}}" name="permissions[]" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{$obje->name}}
                                </label>
                            </div>
                        @endif

                        @if(in_array($obje->name,$readOnly))
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$obje->name}}" name="permissions[]" disabled checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{$obje->name}}
                                    </label>
                                </div>
                        @endif

                        @if(! $kisi->hasPermissionTo($obje->name))
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$obje->name}}" name="permissions[]">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{$obje->name}}
                                    </label>
                                </div>
                        @endif

                    @endforeach
                </div>
            </div>
            <button class="ml-2">Uygula</button>
        </form>
    </div>
@endsection
