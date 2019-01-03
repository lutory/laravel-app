@extends('layouts.admin')

@section('content')
    <h1>Create user</h1>

    {!! Form::open(['method' => 'POST','action' => 'AdminUsersController@store','files'=> true]) !!}

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
        {!! Form::select('is_active', ['1' => 'Active', '0' => 'Inactive'], '0',['class'=>'form-control']); !!}
    </div>

    <div class="form-group">
        {!! Form::label('photo_id', 'Profile Picture') !!}
        {!! Form::file('photo_id',['class'=>'form-control-file']); !!}
    </div>

    <button type="submit" class="btn btn-primary">Create user</button>

    {!! Form::close() !!}
@endsection