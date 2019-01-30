@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h1>Create user</h1>

                {!! Form::open(['method' => 'POST','action' => 'AdminUsersController@store','files'=> true]) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Name<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::password('password',["class"=>"form-control"]) !!}
                    {!! $errors->first('password','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::email('email', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('email','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('role_id', 'Role<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::select('role_id', $roles, null,['placeholder' => 'Pick a role','class'=>'form-control']); !!}
                    {!! $errors->first('role_id','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('is_active', 'Status<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::select('is_active', ['1' => 'Active', '0' => 'Inactive'], '0',['class'=>'form-control']); !!}
                </div>

                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Profile Picture',['class'=>'custom-file-label']) !!}
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add user</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection