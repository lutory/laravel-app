@extends('layouts.admin')

@section('content')



    <h1>Users</h1>

    @if( session('deleted_user') )
        @include('inc.flashmsg',['type'=>'success','msg'=>session('deleted_user')])
    @endif

    @if(count($users)>0)
    <table class="table table-striped table-hover table-sm">
        <thead>
        <tr>
            <th>Id</th>
            <th>Image </th>
            <th>Name </th>
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
                <td><img style="width: 30px;height: 30px" src="{{ $user->photo ?  $user->photo->file : "/images/profile/default.jpg"}}" /></td>
                <td><a href="{{ route('users.edit',$user->id) }}">{{$user->name}}</a></td>
                <td>{{$user->email}}</td>
                <td>{{$user->role->name}}</td>
                <td>{{$user->created_at->diffForHumans()}}</td>
                <td>{{$user->updated_at->diffForHumans()}}</td>
                <td>{{$user->is_active == '1' ? 'Active' : 'Inactive'}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <p>No users</p>
    @endif

@endsection