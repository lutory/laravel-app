@extends('layouts.admin')

@section('content')
    <h1>Tags</h1>
    <div class="row">

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h2>Edit tag <em>{{$tag->name}}</em></h2>
                {!! Form::model($tag,['method' => 'PATCH','action' => ['AdminTagsController@update',$tag->id]]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="error-message">:message</p>') !!}
                </div>
                <button type="submit"  class="add-tag btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Edit tag</button>
                {!! Form::close() !!}
                {!! Form::open(['method' => 'DELETE','action' => ['AdminTagsController@destroy',$tag->id],'id'=>'deleteTagForm']) !!}
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" data-form="deleteTagForm" data-title="Delete Tag" data-message="Are you sure you want to delete this tag ?">Delete tag</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-6">
        <h2>All post in this tag</h2>
        @if(count($tag->posts) > 0)
            <ul>
                @foreach($tag->posts as $post)
                    <li><a href="/admin/posts/{{$post->id}}/edit" target="_blank" >{{$post->title}}</a></li>
                @endforeach
            </ul>
        @else
            <p>No posts yet.</p>
        @endif
    </div>
    </div>
@endsection


@section('scripts')
    @include('inc.deletemodal')
@endsection