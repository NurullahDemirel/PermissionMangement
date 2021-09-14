@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">User id</th>
                        <th scope="col">User Name</th>
                        <th scope="col">User Email</th>
                        <th scope="col">Edit Permission</th>
                        <th scope="col">Edit Role</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>

                                <a href="{{route('edit-permisson',$user->id)}}" class="btn btn-success">Edit Permission</a>
                            </td>
                            <td>
                                <a href="{{route('edit-role',$user->id)}}" class="btn btn-warning" >Edit role</a>

                            </td>
                            <td id="action">
                                <a href="{{route('delete-user',$user->id)}}" class="btn btn-danger"  data-toggle="modal" data-target="#exampleModal{{$user->id}}">Delete User</a>
                                <a href="{{route('edit-user',$user->id)}}" class="btn btn-info" >Edit User</a>
                            </td>
                        </tr>
                        {{--    my model for delete item--}}
                        <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <a href="{{route('delete-user',$user->id)}}" class="btn btn-primary">Delete User</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--    my model for delete item finish--}}
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
