@extends('layouts.admin')

@section('content')


    <h1>Edit user</h1>

    <div class="row">
        <div class="col-2">
            <img width="100%" src="{{ $user->photo ?  $user->photo->file : "/images/profile/default.jpg"}}" alt="">
            <br /><br />
            {!! Form::open(['method' => 'DELETE','action' => ['AdminUsersController@destroy',$user->id],'id'=>'deleteUserForm']) !!}
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" data-form="deleteUserForm" data-title="Delete User" data-message="Are you sure you want to delete this user ?">Delete user</button>
            {!! Form::close() !!}
        </div>
        <div class="col-10">
            {!! Form::model($user,['method' => 'PATCH','action' => ['AdminUsersController@update',$user->id],'files'=> true]) !!}



            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', null,["class"=>"form-control"]) !!}
                {!! $errors->first('name','<p class="error-message">:message</p>') !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password',["class"=>"form-control"]) !!}
                {!! $errors->first('password','<p class="error-message">:message</p>') !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::email('email', null,["class"=>"form-control"]) !!}
                {!! $errors->first('email','<p class="error-message">:message</p>') !!}
            </div>

            <div class="form-group">
                {!! Form::label('role_id', 'Role') !!}
                {!! Form::select('role_id', $roles, null,['placeholder' => 'Pick a role','class'=>'form-control']); !!}
                {!! $errors->first('role_id','<p class="error-message">:message</p>') !!}
            </div>

            <div class="form-group">
                {!! Form::label('is_active', 'Status') !!}
                {!! Form::select('is_active', ['1' => 'Active', '0' => 'Inactive'],null,['class'=>'form-control']); !!}
            </div>

            <div class="form-group">
                {!! Form::label('photo_id', 'Profile Picture') !!}
                {!! Form::file('photo_id',['class'=>'form-control-file']); !!}
            </div>

            <button type="submit" class="btn btn-primary">Edit user</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('scripts')
    @include('inc.deletemodal')
@endsection



