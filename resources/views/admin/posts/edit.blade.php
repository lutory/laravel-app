@extends('layouts.admin')

@section('content')


    <h1>Edit post <em>{{$post->title}}</em></h1>

    {!! Form::model($post,['method' => 'PATCH','action' => ['AdminPostsController@update',$post->id],'files'=> true]) !!}

    <div class="row">
        <div class="col-8">

            <div class="form-group">
                {!! Form::label('title', 'Title') !!}
                {!! Form::text('title', null,["class"=>"form-control"]) !!}
                {!! $errors->first('title','<p class="error-message">:message</p>') !!}
            </div>

            <div class="form-group">
                {!! Form::label('body', 'Body') !!}
                {!! Form::textarea('body', null,["class"=>"form-control tiny-mce"]) !!}
                {!! $errors->first('body','<p class="error-message">:message</p>') !!}
            </div>

            <div class="form-group">
                {!! Form::label('category_id', 'Category') !!}
                {!! Form::select('category_id', $categories, null,['placeholder' => 'Pick a category','class'=>'form-control']); !!}
                {!! $errors->first('category_id','<p class="error-message">:message</p>') !!}
            </div>

            <div class="form-group">
                {!! Form::label('photo_id', 'Featured Image') !!}
                {!! Form::file('photo_id',['class'=>'form-control-file']); !!}
            </div>

            <div class="form-group">
                {!! Form::label('status', 'Status') !!}
                {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], null,['class'=>'form-control']); !!}
            </div>

            {{ Form::hidden('tags[]', null, array('id' => 'tagsIds')) }}

            <button type="submit" class="btn btn-primary">Edit post</button>
        </div>

        <div class="col-4">
            <img width="100%" src="{{ ($post->photo) ?  $post->photo->getPostImagePath($post->photo->file) : "/images/profile/default.jpg"}}" alt="">

            <div class="card mt-2">

                <div class="card-body">
                    <h5 class="card-title">Tags for post:</h5>
                    <div id="postTags">
                        @foreach($post->tags as $tag)
                            <a href="#"  data-name="{{$tag->name}}" data-id="{{$tag->id}}" class="tag-badge badge badge-success">{{$tag->name}} <i class="fas fa-times"></i></a>
                        @endforeach
                    </div>
                    <hr>
                    <h6>Search tag</h6>
                    <input type="text" id="tagSearch" class="form-control" />
                    <div id="searchTags" class="mt-3">
                        @foreach($tags as $tag)
                            <a href="#"  data-id="{{$tag->id}}" class="tag-badge badge badge-primary">{{$tag->name}} </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    {!! Form::open(['method' => 'DELETE','action' => ['AdminPostsController@destroy',$post->id],'id'=>'deletePostForm']) !!}
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" data-form="deletePostForm" data-title="Delete Post" data-message="Are you sure you want to delete this post ?">Delete post</button>
    {!! Form::close() !!}

@endsection
@section('scripts')
    @include('inc.deletemodal')
    @include('inc.admin.tinyMce')
    <script>
        $(document).ready( function(){

            var selectedTagsIds = [];

            if($("#postTags:not(:empty)")){
                $("#postTags a").each(function(){
                    selectedTagsIds.push( $(this).data('id') );
                });
            }

            $("#tagSearch").on('keyup ', function() {
                var search = $(this).val();
                $('#searchTags a').hide();
                $('#searchTags a').each(function () {
                    if($(this).is(':contains("' + search + '")')){
                        $(this).show();
                    }
                });
            });

            $("#searchTags").on('click','a',function (ev) {
                ev.preventDefault();
                var id = $(this).data('id');
                var name = $(this).text();
                selectedTagsIds.push(id);
                $("#postTags").append('<a href="#" data-name="'+name+'" data-id="'+id+'"  class="badge badge-success">'+name+' <i class="fas fa-times"></i></a>');
                $(this).remove();
                $("#tagsIds").val(selectedTagsIds);
            });
            $("#postTags").on('click','a',function (ev) {
                ev.preventDefault();
                var deletedId = $(this).data('id');
                var deletedName = $(this).data('name');
                selectedTagsIds.splice( $.inArray(deletedId, selectedTagsIds), 1 );
                $(this).remove();
                $("#searchTags").append('<a href="#" data-id="'+deletedId+'" class="tag-badge badge badge-primary">'+deletedName+'</a>');
                $("#tagsIds").val(selectedTagsIds);
            });


        } );
    </script>
@endsection
