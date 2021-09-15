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
{{--                        kişi izne direkt sahip ise--}}

                        @if($kisi->hasDirectPermission($obje->name))
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{$obje->name}}" name="permissions[]" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{$obje->name}}
                                </label>
                            </div>
                        @endif
{{--                            kişi bu izne rol icabı sahip ve direk sahip değilse--}}
                        @if($kisi->hasPermissionTo($obje->name) && ! $kisi->hasDirectPermission($obje->name) )
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{$obje->name}}" name="permissions[]" disabled checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{$obje->name}}
                                </label>
                            </div>
                        @endif

{{--                        kişi direct izne sahip değil ve rol icabı bu izine sahip değilse--}}
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
