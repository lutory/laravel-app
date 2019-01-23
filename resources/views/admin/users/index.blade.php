@extends('layouts.admin')

@section('content')


    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h1>Users</h1>

                @if( session('deleted_user') )
                    @include('inc.flashmsg',['type'=>'success','msg'=>session('deleted_user')])
                @endif

                @if(count($users)>0)
                    <div class="table-responsive mb-3">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th>{{$user->id}}</th>
                                    <td><img style="width: 30px;height: 30px"
                                             src="{{ ($user->photo) ?  $user->photo->getUserImagePath($user->photo->file) : "/images/profile/default.jpg"}}"/>
                                    </td>
                                    <td><a href="{{ route('users.edit',$user->id) }}">{{$user->name}}</a></td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role->name}}</td>
                                    <td>{{$user->created_at->diffForHumans()}}</td>
                                    <td>{{$user->updated_at->diffForHumans()}}</td>
                                    <td>@if($user->is_active == '1') <span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Inactive</span> @endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No users</p>
                @endif
            </div>
        </div>
    </div>

@endsection