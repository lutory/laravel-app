@extends('layouts.admin')

@section('content')


    <h1>Edit post <em>{{$post->title}}</em></h1>

    <div class="row">
        <div class="col-2">
            <img width="100%" src="{{ ($post->photo) ?  $post->photo->getPostImagePath($post->photo->file) : "/images/profile/default.jpg"}}" alt="">
            <br /><br />
            {!! Form::open(['method' => 'DELETE','action' => ['AdminPostsController@destroy',$post->id],'id'=>'deletePostForm']) !!}
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" data-form="deletePostForm" data-title="Delete Post" data-message="Are you sure you want to delete this post ?">Delete post</button>
            {!! Form::close() !!}
        </div>
        <div class="col-10">
            {!! Form::model($post,['method' => 'PATCH','action' => ['AdminPostsController@update',$post->id],'files'=> true]) !!}

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
                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], null,['class'=>'form-control']); !!}
            </div>

            <button type="submit" class="btn btn-primary">Edit post</button>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('scripts')
    @include('inc.deletemodal')
@endsection



