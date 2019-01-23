@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h1>Edit category <em>{{$category->name}}</em></h1>
                <hr>

                {!! Form::model($category,['method' => 'PATCH','action' => ['AdminPostsCategoriesController@update',$category->id]]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="text-danger">:message</p>') !!}
                </div>
                <button type="submit"  class="add-category btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit category</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin  stretch-card">
        <div class="card">

            <div class="card-body">
                <h2>Posts:</h2>
                @if(count($category->posts) > 0)
                    <ul class="list-star">
                        @foreach($category->posts as $post)
                            <li><a href="/admin/posts/{{$post->id}}/edit" target="_blank" >{{$post->title}}</a></li>
                        @endforeach
                    </ul>
                @else
                    <p>No posts yet.</p>
                @endif
            </div>
        </div>
    </div>


@endsection


