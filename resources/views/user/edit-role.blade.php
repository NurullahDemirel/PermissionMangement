@extends('layouts.app')
@section('content')
    <div class="container">
        @include('errors.control')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{route('user-roles-edit')}}" method="post">
                    @csrf
                        @foreach($roles as $index=> $role)
                                    <div id="menu">
                                        <input class="form-check-input" type="checkbox" value="{{$role->name}}" name="roles[]"
                                            {{$user->hasRole($role->name) ? 'checked':   ''}}>
                                        <a href="" class="list-group-item checkbox-list-group list-group-item-action active mt-2" data-toggle="collapse" data-target="#sm{{$index}}" data-parent="#menu">{{$role->name}}</a>
                                        @if(($role->permissions->isEmpty()))
                                            <div id="sm{{$index}}" class="sublinks collapse">
                                                Bu role izin ataması bulunmamaktadır
                                            </div>
                                        @else
                                            <div id="sm{{$index}}" class="sublinks collapse">
                                                @foreach($role->permissions as $permission)
                                                    <a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> {{$permission->name}}</a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                        @endforeach
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <button type="submit" class="btn btn-info mt-2 align-content-lg-end">Uygula</button>
                </form>

            </div>
        </div>
    </div>
@endsection
