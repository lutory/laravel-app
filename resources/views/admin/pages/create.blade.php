@extends('layouts.admin')

@section('content')


    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h1>Create page</h1>
                <hr>
                {!! Form::open(['method' => 'POST','action' => 'AdminPagesController@store','files'=> true]) !!}
                <div class="form-group">
                    {!! Form::label('title', 'Title<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::text('title', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('title','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('slug', 'Slug<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::text('slug', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('slug','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('body', 'Body<span class="text-danger">*</span>',[],false) !!}
                    {!! Form::textarea('body', null,["class"=>"form-control tiny-mce"]) !!}
                    {!! $errors->first('body','<p class="text-danger">:message</p>') !!}
                </div>

                <div class="custom-file mb-3">
                    {!! Form::file('photo_id',['class'=>'custom-file-input']); !!}
                    {!! Form::label('photo_id', 'Featured Image',['class'=>'custom-file-label']) !!}
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Post</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    

@endsection
@section('scripts')
    @include('inc.admin.tinyMce')
@endsection