@extends('layouts.admin')

@section('content')
    <h1>Create post</h1>

    {!! Form::open(['method' => 'POST','action' => 'AdminPostsController@store','files'=> true]) !!}

    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', null,["class"=>"form-control"]) !!}
        {!! $errors->first('title','<p class="error-message">:message</p>') !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Body') !!}
        {!! Form::textarea('body', null,["class"=>"form-control"]) !!}
        {!! $errors->first('body','<p class="error-message">:message</p>') !!}
    </div>

    <div class="form-group">
        {!! Form::label('photo_id', 'Featured Image') !!}
        {!! Form::file('photo_id',['class'=>'form-control-file']); !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], 1,['class'=>'form-control']); !!}
    </div>

    <button type="submit" class="btn btn-primary">Create Post</button>

    {!! Form::close() !!}
@endsection