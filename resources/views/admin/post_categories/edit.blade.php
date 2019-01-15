@extends('layouts.admin')

@section('content')
    <h1>Posts Categories</h1>
    <div class="row">

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h2>Edit category <em>{{$category->name}}</em></h2>
                {!! Form::model($category,['method' => 'PATCH','action' => ['AdminPostsCategoriesController@update',$category->id]]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="error-message">:message</p>') !!}
                </div>
                <button type="submit"  class="add-category btn btn-secondary btn-sm"><i class="fas fa-plus"></i> Edit category</button>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
    <div class="col-6">
        <h2>All post in this category</h2>
        @if(count($category->posts) > 0)
            <ul>
                @foreach($category->posts as $post)
                    <li>{{$post->title}}</li>
                @endforeach
            </ul>
        @else
            <p>No posts yet.</p>
        @endif
    </div>
    </div>
@endsection


