@extends('layouts.app')
@section('content')
    <div class="container">
        @include('errors.control')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Role id</th>
                        <th scope="col">Role Name</th>
                        <th scope="col">Permisions</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <th scope="row">{{$role->id}}</th>
                            <td>{{$role->name}}</td>
                            <td>
                                <a class="btn btn-warning" data-toggle="modal" data-target=".bd-example-modal-lg{{$role->id}}">See Permissions</a>
                            </td>
                            <td id="action">
                                <a href="exampleModal{{$role->id}}" class="btn btn-danger"  data-toggle="modal" data-target="#exampleModal{{$role->id}}">Delete Role</a>
                                <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg">Create Role</a>
                            </td>
                        </tr>
                        {{--    my model for delete role start--}}
                        <div class="modal fade" id="exampleModal{{$role->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p>Are you sure</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-secondary" data-dismiss="modal">Cloes</a>
                                        <a href="{{route('delete-role',$role->id)}}" class="btn btn-primary">Delete Role</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--    my model for delete role finish--}}


                        {{--permissons of role start---}}
                        <div class="modal fade bd-example-modal-lg{{$role->id}}" id="permissions{{$role->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class=" modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="card-title">{{$role->name}}'s Permissons</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form  action="{{route('new-role-permission')}}" method="post" class="mt-5">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="container">
                                                @foreach($permissions as $permission)

                                                    <input class="form-check-input" type="checkbox" value="{{$permission->name}}" name="permissions[]" {{$role->hasPermissionTo($permission) ? 'checked':   ''}}>
                                                    <li  class="list-group-item checkbox-list-group list-group-item-action active mt-2"> {{$permission->name}}</li>
                                                @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="role_id" value="{{$role->id}}">
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-dismiss="modal">Cloes</button>
                                                <button type="submit" class="btn btn-primary">Save Role</button>
                                            </div>
                                        </form>
                                    </div>,
                                </div>
                            </div>
                        </div>
                        {{--permissons of role finsih---}}
                    @endforeach
                    </tbody>
                </table>

                {{--    my model for create role start--}}
                <div class="modal fade bd-example-modal-lg" id="permissioncreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class=" modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title">Create Role</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form  action="{{route('create-role')}}" method="post" class="mt-5">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="container">
                                                <label for="rolename" id="rolename">Role Name:</label>
                                                <input type="text" class="input-group @error('role_name') is-invalid @enderror" name="role_name" placeholder="enter a role name"></input>
                                                @error('role_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                                @foreach($permissions as $permission)
                                                    <input class="form-check-input @error('permissions') is-invalid @enderror" type="checkbox" value="{{$permission->name}}" name="permissions[]">
                                                    @error('permissions')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <li  class="list-group-item checkbox-list-group list-group-item-action active mt-2"> {{$permission->name}}</li>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="role_id" value="{{$role->id}}">
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-dismiss="modal">Cloes</button>
                                        <button type="submit" class="btn btn-primary">Save Role</button>
                                    </div>
                                </form>
                            </div>,
                        </div>
                    </div>
                </div>

                {{--    my model for create role finish--}}
            </div>
        </div>
    </div>
@endsection
