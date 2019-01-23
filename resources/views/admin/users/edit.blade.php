@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h1>Edit user <em>{{$user->name}}</em></h1>
                <hr>
                {!! Form::model($user,['method' => 'PATCH','action' => ['AdminUsersController@update',$user->id],'files'=> true,'class'=>'d-inline']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="error-message">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password',["class"=>"form-control"]) !!}
                    {!! $errors->first('password','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('email','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('role_id', 'Role') !!}
                    {!! Form::select('role_id', $roles, null,['placeholder' => 'Pick a role','class'=>'form-control']); !!}
                    {!! $errors->first('role_id','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('is_active', 'Status') !!}
                    {!! Form::select('is_active', ['1' => 'Active', '0' => 'Inactive'],null,['class'=>'form-control']); !!}
                </div>

                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Profile Picture',['class'=>'custom-file-label']) !!}
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit user</button>

                {!! Form::close() !!}

                {!! Form::open(['method' => 'DELETE','action' => ['AdminUsersController@destroy',$user->id],'id'=>'deleteUserForm','class'=>'d-inline float-right']) !!}
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" data-form="deleteUserForm" data-title="Delete User" data-message="Are you sure you want to delete this user ?"><i class="fas fa-trash"></i> Delete user</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin ">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">Profile picture:</h5>
                <img width="100%" src="{{ ($user->photo) ?  $user->photo->getUserImagePath($user->photo->file) : "/images/profile/default.jpg"}}" alt="">
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    @include('inc.deletemodal')
@endsection



