@extends('layouts.admin')

@section('content')

    <div class="col-md-8 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">
                <h1>Edit tag <em>{{$tag->name}}</em></h1>
                <hr>
                {!! Form::model($tag,['method' => 'PATCH','action' => ['AdminTagsController@update',$tag->id],'class'=>'d-inline']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null,["class"=>"form-control"]) !!}
                    {!! $errors->first('name','<p class="text-danger">:message</p>') !!}
                </div>
                <button type="submit"  class="add-tag btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit tag</button>
                {!! Form::close() !!}

                {!! Form::open(['method' => 'DELETE','action' => ['AdminTagsController@destroy',$tag->id],'id'=>'deleteTagForm','class'=>'d-inline float-right']) !!}
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" data-form="deleteTagForm" data-title="Delete Tag" data-message="Are you sure you want to delete this tag ?"><i class="fas fa-trash"></i> Delete tag</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin  stretch-card">
        <div class="card">

            <div class="card-body">
                <h2>Posts:</h2>
                @if(count($tag->posts) > 0)
                    <ul class="list-star">
                        @foreach($tag->posts as $post)
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


@section('scripts')
    @include('inc.deletemodal')
@endsection