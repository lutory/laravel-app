@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h1>Edit page <em>{{$page->title}}</em></h1>
                <hr>
                {!! Form::model($page,['method' => 'PATCH','action' => ['AdminPagesController@update',$page->id],'files'=> true, 'class'=>'d-inline']) !!}

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

                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit page</button>

                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE','action' => ['AdminPagesController@destroy',$page->id],'id'=>'deletePageForm', 'class'=>'d-inline float-right']) !!}
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete"
                        data-form="deletePageForm" data-title="Delete Page"
                        data-message="Are you sure you want to delete this page ?"><i class="fas fa-trash"></i> Delete page
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin ">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">Featured Image:</h5>
                <img width="100%"
                     src="{{ ($page->photo) ?  $page->photo->getPageImagePath($page->photo->file) : "/images/default.png"}}"
                     alt="">
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    @include('inc.deletemodal')
    @include('inc.admin.tinyMce')
@endsection
